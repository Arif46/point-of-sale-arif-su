<?php

namespace App\Http\Controllers\Address;

use App\Http\Validations\Address\BranchValidation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address\Branch;
use Illuminate\Support\Facades\{ Cache, App };
use App\Repositories\Repository;

class BranchController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Branch $branch)
    {
        // set the model
        $this->model = new Repository($branch);
    }

    /**
     * @queryParam name Filter by English Branch name Example: NBR Bank
     * @queryParam limit int Example: 10
     */
    public function list($columns = ['*'], $limit = 10)
    {
        $searchable = [
            'name' => array(
                'name' => 'like',
            ),
            'bank_id'
        ];
        return $this->model->paginate($columns, $searchable, [], $limit);
    }

    /**
     * @queryParam name Filter by English Bank name  Example: NBR Bank
     */
    public function getAll($columns = ['*'])
    {
        $searchable = [
            'name' => array(
                'name' => 'like',
            ),
            'bank_id'
        ];

        return $this->model->getAll($columns, $searchable, [], ['created_at'=> 'DESC']);
    }
    /**
    * @response scenario=success {
    *  "success": true,
    *  "message": "Data Saved Successfully",
    *  "data": {
    *     id: 4,
    *     "name": "NBR BanK",
    *     "address": "dhaka",
    *     "status": "1"
    *     .........
    *   }
    * }
    * @response scenario=Failed {
    *  "success": false,
    *  "message": "Failed to save data"
    *  "errors"  => "....."
    * }
    * @bodyParam name string required Bank Name of the Bank Example: Lalmonirhat.
    * @bodyParam address string required Bank Code of the Bank Example: Dhaka.
    * ......
    */
    public function store(Request $request)
    {
        $validationResult = BranchValidation::validate($request);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        $requestAll = $request->all();
        $data = $this->model->create($requestAll);

        if ($data['success']) {
            Cache::store('redis')->forget('branchs');
            App::make('branchList');
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
    *     "name": "NBR BanK",
    *     "address": "dhaka",
    *     "status": "1"
    *     .........
    *   }
    * }
    * @response scenario=Failed {
    *  "success": false,
    *  "message": "Failed to save data"
    *  "errors"  => "....."
    * }
    * @bodyParam name string required Bank Name of the Bank Example: Lalmonirhat.
    * @bodyParam address string required Bank Code of the Bank Example: Dhaka.
    * ......
    */
    public function update(Request $request, $id)
    {
        $validationResult = BranchValidation::validate($request, $id);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        $requestAll = $request->all();
        $data = $this->model->update($requestAll, $id);
        // return $data;

        if ($data['success']) {
            Cache::store('redis')->forget('branchs');
            App::make('branchList');
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
    *     id: 4,
    *     "name": "NBR Bank",
    *     "address": "1",
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
            Cache::store('redis')->forget('branchs');
            App::make('branchList');
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
            Cache::store('redis')->forget('branchs');
            App::make('branchList');
        }
        return $data;
    }
}
