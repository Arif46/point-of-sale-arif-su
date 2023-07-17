<?php

namespace App\Http\Controllers\ProductManagement;

use App\Http\Validations\ProductManagement\ColorValidation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductManagement\Color;
use Illuminate\Support\Facades\{ Cache, App };
use App\Repositories\Repository;

class ColorController extends Controller
{
     // space that we can use the repository from
     protected $model;

     public function __construct(Color $color)
     {
         // set the model
         $this->model = new Repository($color);
     }

     /**
      * @queryParam name Filter by English category name Example: walton
      * @queryParam limit int Example: 10
      */
     public function list($columns = ['*'], $limit = 10)
     {
         $searchable = [
             'name' => array(
                 'name' => 'like',
             ),
             'shop_id'
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
             'shop_id'
         ];

         return $this->model->getAll($columns, $searchable, [], ['created_at'=> 'DESC']);
     }
     /**
     * @response scenario=success {
     *  "success": true,
     *  "message": "Data Saved Successfully",
     *  "data": {
     *     id: 4,
     *     "name": "red",
     *     "code": "#12541554",
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
         $validationResult = ColorValidation::validate($request);

         if (!$validationResult['success']) {
             return response($validationResult);
         }

         $requestAll = $request->all();
         $data = $this->model->create($requestAll);

         if ($data['success']) {
            Cache::store('redis')->forget('colors');
            App::make('colorList');
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
     *     "name": "red",
     *     "code": "#001211",
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
     public function update(Request $request, $id)
     {
         $validationResult = ColorValidation::validate($request, $id);

         if (!$validationResult['success']) {
             return response($validationResult);
         }

         $requestAll = $request->all();
         $data = $this->model->update($requestAll, $id);
         // return $data;

        if ($data['success']) {
            Cache::store('redis')->forget('colors');
            App::make('colorList');
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
     *     "name": "red",
     *     "code": "#125411",
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
            Cache::store('redis')->forget('colors');
            App::make('colorList');
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
            Cache::store('redis')->forget('colors');
            App::make('colorList');
        }

         return $data;
     }
}
