<?php

namespace App\Http\Controllers\Address;

use App\Http\Validations\Address\PaurosovaValidations;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address\Paurashava;
use Illuminate\Support\Facades\{ Cache, App };
use App\Repositories\Repository;

class PauroshovaController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Paurashava $paurashava)
    {
        // set the model
        $this->model = new Repository($paurashava);
    }

    /**
     * @queryParam name Filter by English paurashava name Example: Rangpur
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
     * @queryParam name Filter by English paurashava name Example: Rangpur
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
 * @bodyParam name string required paurashava Name of the paurashava Example: Nikunja-2.
 * @bodyParam division_id integer required Division Name of the paurashava Example: 1.
 * @bodyParam district_id integer required District Name of the paurashava Example: 1.
 * @bodyParam upazila_id integer required Upazila Name of the paurashava Example: 2.
 * @bodyParam code integer required Division Code of the paurashava Example: 102.
 * ......
 */
    public function store(Request $request)
    {
        $validationResult = PaurosovaValidations::validate($request);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        $requestAll = $request->all();
        $data = $this->model->create($requestAll);

        if ($data['success']) {
            Cache::store('redis')->forget('paurashavas');
            App::make('paurashavaList');
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
 * @bodyParam name string required paurashava Name of the paurashava Example: Nikunja-2.
 * @bodyParam division_id integer required Division Name of the paurashava Example: 1.
 * @bodyParam district_id integer required District Name of the paurashava Example: 1.
 * @bodyParam upazila_id integer required Upazila Name of the paurashava Example: 2.
 * @bodyParam code integer required Division Code of the Division Example: 102.
 * ......
 */
    public function update(Request $request, $id)
    {
        $validationResult = PaurosovaValidations::validate($request, $id);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        $requestAll = $request->all();
        $data = $this->model->update($requestAll, $id);
        // return $data;

        if ($data['success']) {
            Cache::store('redis')->forget('paurashavas');
            App::make('paurashavaList');
        }

        return $data;
    }

    /**
 * @urlParam id integer required The ID of the paurashavas.
 * @urlParam lang The language. Example: en
 * @response scenario=success {
 *     id: 4,
 *     "name": "Nikunja-2",
 *     "division_id": "1",
 *     "district_id": "2",
 *     "upazila_id": "1",
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
     * @urlParam id integer required The ID of the Paurashavas.
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
            Cache::store('redis')->forget('paurashavas');
            App::make('paurashavaList');
        }
        return $data;
    }

    /**
     * @urlParam id integer required The ID of the Paurashavas.
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
            Cache::store('redis')->forget('paurashavas');
            App::make('paurashavaList');
        }
        return $data;
    }
}
