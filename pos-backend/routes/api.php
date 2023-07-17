<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{ Route, Artisan, Cache};

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('', function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
// });

Route::get('common-dropdowns', function () {

    $list = [
        'divisionList'      => App::make('divisionList'),
        'districtList'      => App::make('districtList'),
        'upazilaList'       => App::make('upazilaList'),
        'unionList'         => App::make('unionList'),
        'wardList'          => App::make('wardList'),
        'cityCorporationList' => App::make('cityCorporationList'),
        'paurashavaList'    => App::make('paurashavaList'),
        'shopList'          => App::make('shopList'),
        'roleList'          => App::make('roleList'),
        'categoryList'      => App::make('categoryList'),
        'brandList'         => App::make('brandList'),
        'colorList'         => App::make('colorList'),
        'modelList'         => App::make('modelList'),
        'bankList'         => App::make('bankList'),
        'branchList'       => App::make('branchList'),
    ];

    return response()->json([
        'success' => true,
        'data' => $list
    ]);

});

Route::get('/clear', function () {
    Cache::store('redis')->flush();
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    return "All cache is cleared";
});


include('auth.php');
// include('auth.php');
