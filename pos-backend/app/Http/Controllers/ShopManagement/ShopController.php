<?php

namespace App\Http\Controllers\ShopManagement;

use App\Http\Controllers\Controller;
use App\Http\Validations\ShopManagment\ShopValidation;
use Illuminate\Http\Request;
use App\Models\ShopManagement\Shop;
use Illuminate\Support\Facades\{ Cache, App };
use App\Repositories\Repository;
use App\Helpers\Base64FileUpload;

class ShopController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Shop $shop)
    {
        // set the model
        $this->model = new Repository($shop);
    }

    /**
    * @queryParam name Filter by English name Example: Arif
    * @queryParam limit int Example: 10
    */
    public function list($columns = ['*'], $limit = 10)
    {
        $searchable = [
            'name' => array(
                'name' => 'like',
            ),
           'area_type_id','division_id','district_id', 'upazila_id', 'paurashava_id', 'ward_id', 'name'
        ];
        return $this->model->paginate($columns, $searchable, [], $limit);
    }

    /**
     * @queryParam name Filter by English name Example: Arif
    */
    public function getAll($columns = ['*'])
    {
        $searchable = [
            'name' => array(
                'name' => 'like',
            ),
            'area_type_id','division_id','district_id', 'upazila_id', 'paurashava_id', 'ward_id'
        ];

        return $this->model->getAll($columns, $searchable, [], ['created_at'=> 'DESC']);
    }
    /**
     * @response scenario=success {
     *  "success": true,
     *  "message": "Data Saved Successfully",
     *  "data": {
     *     id: 4,
     *     "name": "Arif",
     *     "mobile": "01742195643",
     *     "owner_name": "Sumon Ahmed",
     *     "owner_mobile": "01737773833,
     *     "area_type_id": "1",
     *     "division_id": "1",
     *     "district_id": "2",
     *     "upazila_id": "1",
     *     "city_corporation_id": "1",
     *     "paurashava_id": "1",
     *     "ward_id": "1",
     *     "status": "1"
     *     .........
     *   }
     * }
     * @response scenario=Failed {
     *  "success": false,
     *  "message": "Failed to save data"
     *  "errors"  => "....."
     * }
     * @bodyParam name string required Shop Name of the Shop Example: Arif.
     * @bodyParam mobile string required Shop Mobile of the Shop Example: 01742195643.
     * @bodyParam owner_name string required Shop owner_name of the Shop Example: Suman Ahmed.
     * @bodyParam owner_mobile string required Shop Mobile of the Shop Example: 01742195643.
     * @bodyParam area_type_id integer required Area Type Id of the Shop Example: 1.
     * @bodyParam division_id integer required Division Name of the Shop Example: 1.
     * @bodyParam district_id integer required District Name of the Shop Example: 1.
     * @bodyParam upazila_id integer required Upazila Name of the Shop Example: 2.
     * @bodyParam city_corporation_id integer required city corporation id Name of the Shop Example: 2.
     * @bodyParam paurashava_id integer required paurashava id Name of the Shop Example: 2.
     * @bodyParam ward_id integer required Ward Id Name of the Shop Example: 2.
     * ......
     */
    public function store(Request $request)
    {
        $validationResult = ShopValidation::validate($request);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        $requestAll = $request->all();

        if($requestAll['logo']) {

            if (\Str::contains($requestAll['logo'], 'base64')) {

                $fileValidation = Base64FileUpload::base64ImageValidation($request, 'logo'); // max 2mb attachment allowed

                if (!$fileValidation['success']) {
                    return response($fileValidation);
                }

                $uploadImage = Base64FileUpload::uploadImage($request, 'logo', '/shop', null, 1200, 631);

                $requestAll['logo'] = $uploadImage['success'] ? $uploadImage['data']: null;
            }

        }

        $data = $this->model->create($requestAll);

        if ($data['success']) {
            Cache::store('redis')->forget('shops');
            App::make('shopList');
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
     *     "name": "Arif",
     *     "mobile": "01742195643",
     *     "owner_name": "Sumon Ahmed",
     *     "owner_mobile": "01737773833,
     *     "area_type_id": "1",
     *     "division_id": "1",
     *     "district_id": "2",
     *     "upazila_id": "1",
     *     "city_corporation_id": "1",
     *     "paurashava_id": "1",
     *     "ward_id": "1",
     *     "status": "1"
     *     .........
     *   }
     * }
     * @response scenario=Failed {
     *  "success": false,
     *  "message": "Failed to save data"
     *  "errors"  => "....."
     * }
     * @bodyParam name string required Shop Name of the Shop Example: Arif.
     * @bodyParam mobile string required Shop Mobile of the Shop Example: 01742195643.
     * @bodyParam owner_name string required Shop owner_name of the Shop Example: Suman Ahmed.
     * @bodyParam owner_mobile string required Shop Mobile of the Shop Example: 01742195643.
     * @bodyParam area_type_id integer required Area Type Id of the Shop Example: 1.
     * @bodyParam division_id integer required Division Name of the Shop Example: 1.
     * @bodyParam district_id integer required District Name of the Shop Example: 1.
     * @bodyParam upazila_id integer required Upazila Name of the Shop Example: 2.
     * @bodyParam city_corporation_id integer required city corporation id Name of the Shop Example: 2.
     * @bodyParam paurashava_id integer required paurashava id Name of the Shop Example: 2.
     * @bodyParam ward_id integer required Ward Id Name of the Shop Example: 2.
     * ......
     */
    public function update(Request $request, $id)
    {
        $validationResult = ShopValidation::validate($request, $id);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        $requestAll = $request->all();

        if($requestAll['logo']) {

            if (\Str::contains($requestAll['logo'], 'base64')) {

                $fileValidation = Base64FileUpload::base64ImageValidation($request, 'logo', null); // max 2mb attachment allowed

                if (!$fileValidation['success']) {
                    return response($fileValidation);
                }

                $uploadImage = Base64FileUpload::uploadImage($request, 'logo', '/shop', null, 1200, 631);

                $requestAll['logo'] = $uploadImage['success'] ? $uploadImage['data']: null;
            }

        }
        $data = $this->model->update($requestAll, $id);
        // return $data;
        if ($data['success']) {
            Cache::store('redis')->forget('shops');
            App::make('shopList');
        }

        return $data;
    }

    /**
     * @urlParam id integer required The ID of the Shop.
     * @urlParam lang The language. Example: en
     * @response scenario=success {
     *    "data": {
     *     id: 4,
     *     "name": "Arif",
     *     "mobile": "01742195643",
     *     "owner_name": "Sumon Ahmed",
     *     "owner_mobile": "01737773833,
     *     "area_type_id": "1",
     *     "division_id": "1",
     *     "district_id": "2",
     *     "upazila_id": "1",
     *     "city_corporation_id": "1",
     *     "paurashava_id": "1",
     *     "ward_id": "1",
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
     * @urlParam id integer required The ID of the Shop.
     * @urlParam lang The language. Example: en
     * @response scenario=success {
     *    "data": {
     *     id: 4,
     *     "name": "Arif",
     *     "mobile": "01742195643",
     *     "owner_name": "Sumon Ahmed",
     *     "owner_mobile": "01737773833,
     *     "area_type_id": "1",
     *     "division_id": "1",
     *     "district_id": "2",
     *     "upazila_id": "1",
     *     "city_corporation_id": "1",
     *     "paurashava_id": "1",
     *     "ward_id": "1",
     *     "status": "1"
     *     .........
     *   }
     * @response scenario="Failed" {
     *  "message": "Data not found"
     * }
     */
    public function destroy($id)
    {
        $data = $this->model->delete($id);

        if ($data['success']) {
            Cache::store('redis')->forget('shops');
            App::make('shopList');
        }
        return $data;
    }

    /**
     * @urlParam id integer required The ID of the Shop.
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
            Cache::store('redis')->forget('shops');
            App::make('shopList');
        }
        return $data;
    }
}
