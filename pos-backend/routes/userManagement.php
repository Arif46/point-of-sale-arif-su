<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManagement\RoleController;

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
Route::group(['prefix'=>'/user-management', 'namespace' => 'UserManagement'], function() {

    // Shop Routes....
    Route::group(['prefix'=>'/role'], function() {
       Route::get('/list', [RoleController::class, 'list']);
       Route::get('/get-all', [RoleController::class, 'getAll']);
       Route::post('/store', [RoleController::class, 'store']);
       Route::put('/update/{id}', [RoleController::class, 'update']);
       Route::get('/show/{id}', [RoleController::class, 'show']);
       Route::delete('/toggle-status/{id}', [RoleController::class, 'toggleStatus']);
       Route::delete('/destroy/{id}', [RoleController::class, 'destroy']);
    });

});
