<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Validations\UserManagement\RoleValidations;
use Illuminate\Http\Request;
use App\Models\UserManagement\Role;
use Illuminate\Support\Facades\{ Cache, App };
use App\Repositories\Repository;

class RoleController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Role $role)
    {
        // set the model
        $this->model = new Repository($role);
    }

    /**
     * @queryParam name Filter by English Role name Example: Arif
     * @queryParam limit int Example: 10
     */
    public function list($columns = ['*'], $limit = 10)
    {
        $searchable = [
            'shop_id',
            'name' => array(
                'name' => 'like',
            )
        ];
        return $this->model->paginate($columns, $searchable, [], $limit);
    }

    /**
     * @queryParam name Filter by English Role name  Example: Arif
     */
    public function getAll($columns = ['*'])
    {
        $searchable = [
            'shop_id',
            'name' => array(
                'name' => 'like',
            )
        ];

        return $this->model->getAll($columns, $searchable, [], ['created_at'=> 'DESC']);
    }
    /**
    * @response scenario=success {
    *  "success": true,
    *  "message": "Data Saved Successfully",
    *  "data": {
    *     id: 4,
    *     "name": "arif",
    *     "shop_id": "1",
    *     "status": "1"
    *     .........
    *   }
    * }
    * @response scenario=Failed {
    *  "success": false,
    *  "message": "Failed to save data"
    *  "errors"  => "....."
    * }
    * @bodyParam name string required Bank Name of the Role Example: Arif.
    * @bodyParam shop_id integer required Bank Code of the Role Example: 1.
    * ......
    */
    public function store(Request $request)
    {
        $validationResult = RoleValidations::validate($request);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        $requestAll = $request->all();
        $data = $this->model->create($requestAll);

        if ($data['success']) {
            Cache::store('redis')->forget('roles');
            App::make('roleList');
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
    *     "name": "arif",
    *     "shop_id": "1",
    *     "status": "1"
    *     .........
    *   }
    * }
    * @response scenario=Failed {
    *  "success": false,
    *  "message": "Failed to save data"
    *  "errors"  => "....."
    * }
    * @bodyParam name string required Bank Name of the Role Example: Arif.
    * @bodyParam shop_id integer required Bank Code of the Role Example: 1.
    * ......
    */
    public function update(Request $request, $id)
    {
        $validationResult = RoleValidations::validate($request, $id);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        $requestAll = $request->all();
        $data = $this->model->update($requestAll, $id);
        // return $data;

        if ($data['success']) {
            Cache::store('redis')->forget('roles');
            App::make('roleList');
        }

        return [
            'success' => true,
            'message' => 'Data Update Sucessfully',
            'data' => $data
        ];
    }

    /**
    * @urlParam id integer required The ID of the Master Component.
    * @urlParam lang The language. Example: en
    * @response scenario=success {
    *    "data": {
    *     id: 4,
    *     "name": "arif",
    *     "shop_id": "1",
    *     "status": "1"
    *     .........
    *   }
    * @response scenario="Failed" {
    *  "message": "Data not found"
    * }
    */
    public function show($id)
    {
        return $this->model->show($id, $columns = ['*']);
    }

    /**
     * @urlParam id integer required The ID of the Role.
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
            Cache::store('redis')->forget('roles');
            App::make('roleList');
        }
        return $data;
    }

    /**
     * @urlParam id integer required The ID of the Role.
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
            Cache::store('redis')->forget('roles');
            App::make('roleList');
        }
        return $data;
    }
}
