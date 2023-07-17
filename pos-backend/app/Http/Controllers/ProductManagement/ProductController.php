<?php

namespace App\Http\Controllers\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Validations\ProductManagement\ProductValidation;
use Illuminate\Http\Request;
use App\Models\ProductManagement\Product;
use Illuminate\Support\Facades\{ Cache, App };
use App\Repositories\Repository;

class ProductController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Product $product)
    {
        // set the model
        $this->model = new Repository($product);
    }

    /**
    * @queryParam name Filter by English Product name Example: walton
    * @queryParam limit int Example: 10
    */
    public function list($columns = ['*'], $limit = 10)
    {
        $searchable = [
            'name' => array(
                'name' => 'like',
            ),
            'code', 'shop_id', 'supplier_id', 'category_id', 'brand_id', 'unit_id', 'size_id'
        ];
        return $this->model->paginate($columns, $searchable, [], $limit);
    }

    /**
     * @queryParam name Filter by English category name Example: walton
    */
    public function getAll($columns = ['*'])
    {
        $searchable = [
            'name' => array(
                'name' => 'like',
            ),
            'code', 'shop_id', 'supplier_id', 'category_id', 'brand_id', 'unit_id', 'size_id'
        ];

         return $this->model->getAll($columns, $searchable, [], ['created_at'=> 'DESC']);
     }
     /**
     * @response scenario=success {
     *  "success": true,
     *  "message": "Data Saved Successfully",
     *  "data": {
     *     id: 4,
     *     "name": "samsung",
     *     "code": "5555",
     *     "shop_id": "10",
     *     "supplier_id": "1",
     *     "category_id": "1",
     *     "brand_id": "1",
     *     "unit_id": "1",
     *     "size_id": "1",
     *     "status": "1"
     *     .........
     *   }
     * }
     * @response scenario=Failed {
     *  "success": false,
     *  "message": "Failed to save data"
     *  "errors"  => "....."
     * }
     * @bodyParam name string required category Name of the category Example: Walton.
     * @bodyParam code integer required category Code of the category Example: 102.
     * ......
     */
     public function store(Request $request)
     {
         $validationResult = ProductValidation::validate($request);

         if (!$validationResult['success']) {
             return response($validationResult);
         }

         $requestAll = $request->all();
         $data = $this->model->create($requestAll);

         if ($data['success']) {
            Cache::store('redis')->forget('products');
            App::make('productList');
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
     *     "name": "samsung",
     *     "code": "5555",
     *     "shop_id": "10",
     *     "supplier_id": "1",
     *     "category_id": "1",
     *     "brand_id": "1",
     *     "unit_id": "1",
     *     "size_id": "1",
     *     "status": "1"
     *     .........
     *   }
     * }
     * @response scenario=Failed {
     *  "success": false,
     *  "message": "Failed to save data"
     *  "errors"  => "....."
     * }
     * @bodyParam name string required category Name of the Product Example: Walton.
     * @bodyParam code integer required category Code of the Product Example: 102.
     * ......
     */
     public function update(Request $request, $id)
     {
        $validationResult = ProductValidation::validate($request, $id);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        $requestAll = $request->all();
        $data = $this->model->update($requestAll, $id);
        // return $data;

        if ($data['success']) {
            Cache::store('redis')->forget('products');
            App::make('productList');
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
     *     "name": "samsung",
     *     "code": "5555",
     *     "shop_id": "10",
     *     "supplier_id": "1",
     *     "category_id": "1",
     *     "brand_id": "1",
     *     "unit_id": "1",
     *     "size_id": "1",
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
            Cache::store('redis')->forget('products');
            App::make('productList');
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
            Cache::store('redis')->forget('products');
            App::make('productList');
        }

        return $data;
     }
}
