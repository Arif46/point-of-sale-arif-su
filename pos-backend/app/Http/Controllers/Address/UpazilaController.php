<?php

namespace App\Http\Controllers\Address;

use App\Http\Validations\Address\UpazilaValidations;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address\Upazilla;
use Illuminate\Support\Facades\{ Cache, App };
use App\Repositories\Repository;

class UpazilaController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Upazilla $upazila)
    {
        // set the model
        $this->model = new Repository($upazila);
    }

    /**
     * @queryParam name Filter by English District name Example: Lalmonirhat
     * @queryParam limit int Example: 10
     */
    public function list($columns = ['*'], $limit = 10)
    {
        $searchable = [
            'name' => array(
                'name' => 'like',
            ),
            'district_id'
        ];
        return $this->model->paginate($columns, $searchable, [], $limit);
    }

    /**
     * @queryParam name Filter by English District name Example: Lalmonirhat
     */
    public function getAll($columns = ['*'])
    {
        $searchable = [
            'name' => array(
                'name' => 'like',
            ),
            'district_id'
        ];

        return $this->model->getAll($columns, $searchable, [], ['created_at'=> 'DESC']);
    }
    /**
    * @response scenario=success {
    *  "success": true,
    *  "message": "Data Saved Successfully",
    *  "data": {
    *     id: 4,
    *     "name": "Kaligonj",
    *     "district_id": "1",
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
    * @bodyParam name string required Upazila Name of the Upazila Example: Kaligonj.
    * @bodyParam code integer required Upazila Code of the Upazila Example: 102.
    * @bodyParam district_id integer required District Id of the Upazila Example: 1.
    * ......
    */
    public function store(Request $request)
    {
        $validationResult = UpazilaValidations::validate($request);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        $requestAll = $request->all();
        $data = $this->model->create($requestAll);

        if ($data['success']) {
            Cache::store('redis')->forget('upazillas');
            App::make('upazilaList');
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
    *     "name": "Kaligonj",
    *     "district_id": "1",
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
    * @bodyParam name string required Upazila Name of the Upazila Example: Kaligonj.
    * @bodyParam code integer required Upazila Code of the Upazila Example: 102.
    * @bodyParam district_id integer required District Id of the Upazila Example: 1.
    * ......
    */
    public function update(Request $request, $id)
    {
        $validationResult = UpazilaValidations::validate($request, $id);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        $requestAll = $request->all();
        $data = $this->model->update($requestAll, $id);
        // return $data;

        if ($data['success']) {
            Cache::store('redis')->forget('upazillas');
            App::make('upazilaList');
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
    *     "name": "Kaligonj",
    *     "district_id": "1",
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
            Cache::store('redis')->forget('upazillas');
            App::make('upazilaList');
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
            Cache::store('redis')->forget('upazillas');
            App::make('upazilaList');
        }
        return $data;
    }
}
