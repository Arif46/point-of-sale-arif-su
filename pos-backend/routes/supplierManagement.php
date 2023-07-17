<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\supplierManagement\{
    SupplierController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix'=>'/supplier-management', 'namespace' => 'SupplierManagement'], function() {

    // Category Routes....
    Route::group(['prefix'=>'/supplier'], function() {
       Route::get('/list', [SupplierController::class, 'list']);
       Route::get('/get-all', [SupplierController::class, 'getAll']);
       Route::post('/store', [SupplierController::class, 'store']);
       Route::put('/update/{id}', [SupplierController::class, 'update']);
       Route::get('/show/{id}', [SupplierController::class, 'show']);
       Route::delete('/toggle-status/{id}', [SupplierController::class, 'toggleStatus']);
       Route::delete('/destroy/{id}', [SupplierController::class, 'destroy']);
    });

});
