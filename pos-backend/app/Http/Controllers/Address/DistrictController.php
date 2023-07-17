<?php

namespace App\Http\Controllers\Address;

use App\Http\Validations\Address\DistrictValidations;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address\District;
use Illuminate\Support\Facades\{ Cache, App };
use App\Repositories\Repository;

class DistrictController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(District $district)
    {
        // set the model
        $this->model = new Repository($district);
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
            'division_id'
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
    *     "name": "Lalmonirhat",
    *     "division_id": "1",
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
    * @bodyParam name string required District Name of the District Example: Lalmonirhat.
    * @bodyParam code integer required District Code of the District Example: 102.
    * @bodyParam division_id integer required Division Id of the District Example: 1.
    * ......
    */
    public function store(Request $request)
    {
        $validationResult = DistrictValidations::validate($request);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        $requestAll = $request->all();
        $data = $this->model->create($requestAll);

        if ($data['success']) {
            Cache::store('redis')->forget('districts');
            App::make('districtList');
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
    *     "name": "Lalmonirhat",
    *     "division_id": "1",
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
    * @bodyParam name string required District Name of the District Example: Lalmonirhat.
    * @bodyParam code integer required District Code of the District Example: 102.
    * @bodyParam division_id integer required Division Id of the District Example: 1.
    * ......
    */
    public function update(Request $request, $id)
    {
        $validationResult = DistrictValidations::validate($request, $id);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        $requestAll = $request->all();
        $data = $this->model->update($requestAll, $id);
        // return $data;

        if ($data['success']) {
            Cache::store('redis')->forget('districts');
            App::make('districtList');
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
    *     "name": "Lalmonirhat",
    *     "division_id": "1",
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
            Cache::store('redis')->forget('districts');
            App::make('districtList');
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
            Cache::store('redis')->forget('districts');
            App::make('districtList');
        }
        return $data;
    }
}
