<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopManagement\ShopController;

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
Route::group(['prefix'=>'/shop-management', 'namespace' => 'ShopManagement'], function() {

    // Shop Routes....
    Route::group(['prefix'=>'/shop'], function() {
       Route::get('/list', [ShopController::class, 'list']);
       Route::get('/get-all', [ShopController::class, 'getAll']);
       Route::post('/store', [ShopController::class, 'store']);
       Route::put('/update/{id}', [ShopController::class, 'update']);
       Route::get('/show/{id}', [ShopController::class, 'show']);
       Route::delete('/toggle-status/{id}', [ShopController::class, 'toggleStatus']);
       Route::delete('/destroy/{id}', [ShopController::class, 'destroy']);
    });

});
