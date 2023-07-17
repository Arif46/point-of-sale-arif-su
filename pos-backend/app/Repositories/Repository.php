<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\{Auth, Cache, DB, Redis};
use Log;

class Repository implements RepositoryInterface
{
    // model property on class instances
    protected $model;
    protected $second;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->second = 2;
    }

    // Get all instances of model
    public function all($columns = ['*'])
    {
        $list = $this->model->all($columns);

        if ($list->isEmpty()) {
            return [
                'success' => false,
                'message' => 'Data Not Found'
            ];
        }

        return [
            'success' => true,
            'message' => 'List',
            'data' => $list
        ];
    }

    //rememberKey
    public function rememberKey() {
        $url = request()->url();
        $queryParams = request()->query();
        ksort($queryParams);
        $queryString = http_build_query($queryParams);
        $fullUrl = "{$url}?{$queryString}";
        $rememberKey = sha1($fullUrl);
        return $rememberKey;
    }

    //scopeSet
    public function scopeSet($conditions) {
        foreach ($conditions as $key => $value) {
            if (is_string($key)) {
                $scopes[$key] = $value;
            } else {
                $scopes[$value] = 'where';
            }
        }
        return $scopes;
    }

    //multiDymensionconditionSet
    public function multiConditionSet($key, $checkKey, $value, $query) {
        $field = request()->$checkKey;
        if ($value == 'like' && request()->$checkKey) {
            $query->where($key, 'like', "%$field%");
        } else if ($value == 'or' && request()->$checkKey) {
            $query->orWhere($key, $field);
        } else if ($value == 'orLike'&& request()->$checkKey) {
            $query->orWhere($key, 'like', "%$field%");
        } else if($value == 'where' && request()->$checkKey) {
            $query->where($key, request()->$key);
        }
        return $query;
    }

    // Get all List of model
    public function paginate($columns = ['*'], $conditions = [], $relations = [], $limit = 10)
    {
        $rememberKey = $this->rememberKey();
        if (request()->limit) {
            $limit = request()->limit;
        }
        $list = Cache::store('redis')->remember($rememberKey, $this->second, function () use ($columns, $conditions, $relations, $limit) {
            $query = $this->model->latest();
            if (!empty($relations)) {
                $query->with($relations);
            }
            $scopes = $this->scopeSet($conditions);
            if (!empty($scopes)) {
                foreach ($scopes as $key => $value) {
                    $field = request()->$key;
                    if (is_string($value)) {
                        $query = $this->multiConditionSet($key, $key, $value, $query);
                    } else {
                        $query->where(function ($query1) use ($key, $value, $field) {
                            foreach ($value as $key1 => $value1) {
                                $query1 = $this->multiConditionSet($key1, $key, $value1, $query1);
                            }
                        });
                    }
                }
            }
            return $query->paginate($limit, $columns);
        });

        if ($list->isEmpty()) {
            return [
                'success' => false,
                'message' => 'Data Not Found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Data Found',
            'data' => $list
        ];
    }

    public function getAll($columns = ['*'], $conditions = [], $relations = [], $ordeBy = [])
    {
        $rememberKey = $this->rememberKey();
        $list = Cache::store('redis')->remember($rememberKey, $this->second, function () use ($columns, $conditions, $relations, $ordeBy) {

            $query = $this->model::select($columns);
            if (!empty($relations)) {
                $query->with($relations);
            }
            $scopes = $this->scopeSet($conditions);
            if (!empty($scopes)) {
                foreach ($scopes as $key => $value) {
                    $field = request()->$key;
                    if (is_string($value)) {
                        $query = $this->multiConditionSet($key, $key, $value, $query);
                    } else {
                        $query->where(function ($query1) use ($key, $value, $field) {
                            foreach ($value as $key1 => $value1) {
                                $query1 = $this->multiConditionSet($key1, $key, $value1, $query1);
                            }
                        });
                    }
                }
            }
            if (!empty($ordeBy)) {
                foreach ($ordeBy as $key => $value) {
                    $query->orderBy($key, $value);
                }
            }
            return $query->get();
        });

        if ($list->isEmpty()) {
            return [
                'success' => false,
                'message' => 'Data Not Found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Data Found',
            'data' => $list
        ];
    }

    // create a new record in the database
    public function create(array $data, $relationArr = [])
    {
        DB::beginTransaction();

        try {
            $model = $this->model->create($data);

            if ($relationArr) {
                foreach ($relationArr as $relation => $relationData) {
                    if (count($relationData) == count($relationData, COUNT_RECURSIVE)) {
                        $model->$relation()->create($relationData);
                    } else {
                        $model->$relation()->createMany($relationData);
                    }
                }
            }

            // save_log([
            //     'data_id'   => $model->id,
            //     'table_name'=> $model->getTable(),
            //     'execution_type' => 1
            // ]);

            DB::commit();

        } catch (\Exception $ex) {

            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Failed to saved data.',
                'errors'  => env('APP_ENV') !== 'production' ? $ex->getMessage() : []
            ];
        }

        return [
            'success' => true,
            'message' => 'Data saved successfully',
            'model'    => $model
        ];
    }

    // update record in the database
    public function update(array $data, $id, $relationArr = [])
    {
        try {
            $model = $this->model->find($id);

            if (!$model) {
                return [
                    'success' => false,
                    'message' => 'Data not found.'
                ];
            }

            $model->update($data);

            // save_log([
            //     'data_id'    => $model->id,
            //     'table_name' => $model->getTable(),
            //     'execution_type'=> 2
            // ]);

            if ($relationArr) {
                foreach ($relationArr as $relation => $relationData) {
                    if (count($relationData) == count($relationData, COUNT_RECURSIVE)) {
                        $model->$relation()->update($relationData);
                    } else {
                        $model->$relation()->delete();
                        $model->$relation()->createMany($relationData);
                    }
                }
            }

        } catch (\Exception $ex) {

            return [
                'success' => false,
                'message' => 'Failed to update data.',
                'errors'  => env('APP_ENV') !== 'production' ? $ex->getMessage() : []
            ];
        }

        return [
            'success' => true,
            'message' => 'Data updated successfully',
            'model'    => $model
        ];
    }

    // remove record from the database
    public function delete($id)
    {
        $model = $this->model->find($id);

        if (!$model) {

            return [
                'success' => false,
                'message' => 'Data not found.'
            ];
        }
        $model->delete();

        // save_log([
        //     'data_id' => $model->id,
        //     'table_name' => $model->getTable(),
        //     'execution_type' => 3
        // ]);

        return [
            'success' => true,
            'message' => 'Data deleted successfully'
        ];
    }

    // Toogle Status change from the database
    public function toggleStatus($id)
    {
        $model = $this->model->find($id);

        if (!$model) {
            return [
                'success' => false,
                'message' => 'Data not found.'
            ];
        }

        $model->status = $model->status == 1 ? 2 : 1;
        $model->update();

        // save_log([
        //     'data_id' => $model->id,
        //     'table_name' => $model->getTable(),
        //     'execution_type' => 2
        // ]);

        return [
            'success' => true,
            'message' => 'Data updated successfully',
            'data'    => $model
        ];
    }

    // show the record with the given id
    public function show($id, $columns = ['*'], $relations= [])
    {
        $rememberKey = $this->rememberKey();

        $model = Cache::store('redis')->remember($rememberKey, $this->second, function () use ($id, $columns, $relations) {
            $query = $this->model->where('id', $id);
            $query->select($columns);
            if (!empty($relations)) {
                $query->with($relations);
            }
            return $query->first();
        });

        if (!$model) {
            return [
                'success' => false,
                'message' => 'Data not found.'
            ];
        }

        return [
            'success' => true,
            'message' => 'Data found.',
            'data' => $model
        ];
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations)->latest();
    }
}
