<?php

namespace App\Http\Controllers\SupplierManagement;

use App\Http\Validations\SupplierManagement\SupplierValidation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupplierManagement\Supplier;
use Illuminate\Support\Facades\{ Cache, App };
use App\Repositories\Repository;

class SupplierController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Supplier $supplier)
    {
       // set the model
       $this->model = new Repository($supplier);
    }

    /**
     * @queryParam name Filter by English Supplier name Example: ABC
     * @queryParam limit int Example: 10
    */
    public function list($columns = ['*'], $limit = 10)
    {
        $searchable = [
            'name' => array(
                'name' => 'like',
            ),
            'address' => array(
                'address' => 'like',
            ),
            'code', 'shop_id', 'mobile'
        ];
        return $this->model->paginate($columns, $searchable, [], $limit);
    }

    /**
    * @queryParam name Filter by English Supplier name Example: ABC
     */
    public function getAll($columns = ['*'])
    {
        $searchable = [
            'name' => array(
                'name' => 'like',
            ),
            'address' => array(
                'address' => 'like',
            ),
            'code', 'shop_id', 'mobile'
        ];

        return $this->model->getAll($columns, $searchable, [], ['created_at'=> 'DESC']);
    }
    /**
    * @response scenario=success {
    *  "success": true,
    *  "message": "Data Saved Successfully",
    *  "data": {
    *     id: 4,
    *     "name": "walton",
    *     "code": "120",
    *     "status": "1"
    *     .........
    *   }
    * }
    * @response scenario=Failed {
    *  "success": false,
    *  "message": "Failed to save data"
    *  "errors"  => "....."
    * }
    * @bodyParam name string required Supplier Name of the Supplier Example: Walton.
    * @bodyParam code integer required Supplier Code of the Supplier Example: 102.
    * ......
    */
    public function store(Request $request)
    {
        $validationResult = SupplierValidation::validate($request);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        $requestAll = $request->all();
        $data = $this->model->create($requestAll);

        if ($data['success']) {
            Cache::store('redis')->forget('suppliers');
            App::make('supplierList');
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
    *     "name": "walton",
    *     "code": "120",
    *     "status": "1"
    *     .........
    *   }
    * }
    * @response scenario=Failed {
    *  "success": false,
    *  "message": "Failed to save data"
    *  "errors"  => "....."
    * }
    * @bodyParam name string required Supplier Name of the Supplier Example: Walton.
    * @bodyParam code integer required Supplier Code of the Supplier Example: 102.
    * ......
    */
    public function update(Request $request, $id)
    {
       $validationResult = SupplierValidation::validate($request, $id);

       if (!$validationResult['success']) {
           return response($validationResult);
       }

       $requestAll = $request->all();
       $data = $this->model->update($requestAll, $id);
       // return $data;

       if ($data['success']) {
           Cache::store('redis')->forget('suppliers');
           App::make('supplierList');
       }

       return [
           'success' => true,
           'message' => 'Data Update Sucessfully',
           'data' => $data
       ];
    }

    /**
    * @urlParam id integer required The ID of the Category.
    * @urlParam lang The language. Example: en
    * @response scenario=success {
    *     id: 4,
    *     "name": "walton",
    *     "code": "120",
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
     * @urlParam id integer required The ID of the Category.
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
            Cache::store('redis')->forget('suppliers');
            App::make('supplierList');
        }

        return $data;
    }

    /**
     * @urlParam id integer required The ID of the Category.
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
            Cache::store('redis')->forget('suppliers');
            App::make('supplierList');
        }

       return $data;
    }
}
