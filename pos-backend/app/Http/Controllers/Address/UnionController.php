<?php

namespace App\Http\Controllers\Address;

use App\Http\Validations\Address\UnionValidaions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address\Union;
use Illuminate\Support\Facades\{ Cache, App };
use App\Repositories\Repository;

class UnionController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Union $union)
    {
        // set the model
        $this->model = new Repository($union);
    }

    /**
     * @queryParam name Filter by English Division name Example: Rangpur
     * @queryParam limit int Example: 10
     */
    public function list($columns = ['*'], $limit = 10)
    {
        $searchable = [
            'name' => array(
                'name' => 'like',
            ),
            'division_id','district_id', 'upazila_id'
        ];
        return $this->model->paginate($columns, $searchable, [], $limit);
    }

    /**
     * @queryParam name Filter by English Division name Example: Rangpur
     */
    public function getAll($columns = ['*'])
    {
        $searchable = [
            'name' => array(
                'name' => 'like',
            ),
            'division_id','district_id', 'upazila_id'
        ];

        return $this->model->getAll($columns, $searchable, [], ['created_at'=> 'DESC']);
    }
    /**
    * @response scenario=success {
    *  "success": true,
    *  "message": "Data Saved Successfully",
    *  "data": {
    *     id: 4,
    *     "name": "Nikunja-2",
    *     "division_id": "1",
    *     "district_id": "2",
    *     "upazila_id": "1",
    *     "code": "102",
    *     "status": "1"
    *     .........
    *   }
    * }
    * @response scenario=Failed {
    *  "success": false,
    *  "message": "Failed to save data"
    *  "errors"  => "....."
    * }
    * @bodyParam name string required Union Name of the Union Example: Nikunja-2.
    * @bodyParam division_id integer required Division Name of the Union Example: 1.
    * @bodyParam district_id integer required District Name of the Union Example: 1.
    * @bodyParam upazila_id integer required Upazila Name of the Union Example: 2.
    * @bodyParam code integer required Division Code of the Division Example: 102.
    * ......
    */
    public function store(Request $request)
    {
        $validationResult = UnionValidaions::validate($request);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        $requestAll = $request->all();
        $data = $this->model->create($requestAll);

        if ($data['success']) {
            Cache::store('redis')->forget('unions');
            App::make('unionList');
        }

        return [
            'success' => true,
            'message' => 'Data Save Sucessfully',
            'data' => $data
        ];
    }
    /**
    * @response scenario=success {
    *  "success": true,
    *  "message": "Data Saved Successfully",
    *  "data": {
    *     id: 4,
    *     "name": "Nikunja-2",
    *     "division_id": "1",
    *     "district_id": "2",
    *     "upazila_id": "1",
    *     "code": "102",
    *     "status": "1"
    *     .........
    *   }
    * }
    * @response scenario=Failed {
    *  "success": false,
    *  "message": "Failed to save data"
    *  "errors"  => "....."
    * }
    * @bodyParam name string required Union Name of the Union Example: Nikunja-2.
    * @bodyParam division_id integer required Division Name of the Union Example: 1.
    * @bodyParam district_id integer required District Name of the Union Example: 1.
    * @bodyParam upazila_id integer required Upazila Name of the Union Example: 2.
    * @bodyParam code integer required Division Code of the Division Example: 102.
    * ......
    */
    public function update(Request $request, $id)
    {
        $validationResult = UnionValidaions::validate($request, $id);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        $requestAll = $request->all();
        $data = $this->model->update($requestAll, $id);
        // return $data;

        if ($data['success']) {
            Cache::store('redis')->forget('unions');
            App::make('unionList');
        }

        return $data;
    }

    /**
    * @urlParam id integer required The ID of the Master Component.
    * @urlParam lang The language. Example: en
    * @response scenario=success {
    *     id: 4,
    *     "name": "Rangpur",
    *     "code": "102",
    *     "status": "1"
    *     .........
    * }
    * @response scenario="Failed" {
    *  "message": "Data not found"
    * }
    */
    public function show($id)
    {
        return $this->model->show($id, $columns = ['*']);
    }

    /**
     * @urlParam id integer required The ID of the Master Division.
     * @response scenario=success {
     *  "message": "Data deleted successfully"
     * }
     * @response scenario="Failed" {
     *  "message": "Data not found"
     * }
     */
    public function destroy($id)
    {
        $data = $this->model->delete($id);

        if ($data['success']) {
            Cache::store('redis')->forget('unions');
            App::make('unionList');
        }
        return $data;
    }

    /**
     * @urlParam id integer required The ID of the MasterComponent.
     * @response scenario=success {
     *  "message": "Data updated successfully"
     * }
     * @response scenario="Failed" {
     *  "message": "Data not found"
     * }
     */
    public function toggleStatus($id)
    {
        $data = $this->model->toggleStatus($id);

        if ($data['success']) {
            Cache::store('redis')->forget('unions');
            App::make('unionList');
        }
        return $data;
    }

}
