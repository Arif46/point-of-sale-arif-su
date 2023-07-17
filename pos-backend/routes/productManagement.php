<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductManagement\{
    CategoryController,
    BrandController,
    ColorController,
    ModelController,
    SizeController,
    UnitController,
    ProductController
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
Route::group(['prefix'=>'/product-management', 'namespace' => 'ProductManagement'], function() {

    // Category Routes....
    Route::group(['prefix'=>'/category'], function() {
       Route::get('/list', [CategoryController::class, 'list']);
       Route::get('/get-all', [CategoryController::class, 'getAll']);
       Route::post('/store', [CategoryController::class, 'store']);
       Route::put('/update/{id}', [CategoryController::class, 'update']);
       Route::get('/show/{id}', [CategoryController::class, 'show']);
       Route::delete('/toggle-status/{id}', [CategoryController::class, 'toggleStatus']);
       Route::delete('/destroy/{id}', [CategoryController::class, 'destroy']);
    });

     // Brand Routes....
     Route::group(['prefix'=>'/brand'], function() {
        Route::get('/list', [BrandController::class, 'list']);
        Route::get('/get-all', [BrandController::class, 'getAll']);
        Route::post('/store', [BrandController::class, 'store']);
        Route::put('/update/{id}', [BrandController::class, 'update']);
        Route::get('/show/{id}', [BrandController::class, 'show']);
        Route::delete('/toggle-status/{id}', [BrandController::class, 'toggleStatus']);
        Route::delete('/destroy/{id}', [BrandController::class, 'destroy']);
     });

    // color Routes....
      Route::group(['prefix'=>'/color'], function() {
        Route::get('/list', [ColorController::class, 'list']);
        Route::get('/get-all', [ColorController::class, 'getAll']);
        Route::post('/store', [ColorController::class, 'store']);
        Route::put('/update/{id}', [ColorController::class, 'update']);
        Route::get('/show/{id}', [ColorController::class, 'show']);
        Route::delete('/toggle-status/{id}', [ColorController::class, 'toggleStatus']);
        Route::delete('/destroy/{id}', [ColorController::class, 'destroy']);
    });

      // Model Routes....
      Route::group(['prefix'=>'/model'], function() {
        Route::get('/list', [ModelController::class, 'list']);
        Route::get('/get-all', [ModelController::class, 'getAll']);
        Route::post('/store', [ModelController::class, 'store']);
        Route::put('/update/{id}', [ModelController::class, 'update']);
        Route::get('/show/{id}', [ModelController::class, 'show']);
        Route::delete('/toggle-status/{id}', [ModelController::class, 'toggleStatus']);
        Route::delete('/destroy/{id}', [ModelController::class, 'destroy']);
     });

      // size Routes....
      Route::group(['prefix'=>'/size'], function() {
        Route::get('/list', [SizeController::class, 'list']);
        Route::get('/get-all', [SizeController::class, 'getAll']);
        Route::post('/store', [SizeController::class, 'store']);
        Route::put('/update/{id}', [SizeController::class, 'update']);
        Route::get('/show/{id}', [SizeController::class, 'show']);
        Route::delete('/toggle-status/{id}', [SizeController::class, 'toggleStatus']);
        Route::delete('/destroy/{id}', [SizeController::class, 'destroy']);
     });

      // Unit Routes....
      Route::group(['prefix'=>'/unit'], function() {
        Route::get('/list', [UnitController::class, 'list']);
        Route::get('/get-all', [UnitController::class, 'getAll']);
        Route::post('/store', [UnitController::class, 'store']);
        Route::put('/update/{id}', [UnitController::class, 'update']);
        Route::get('/show/{id}', [UnitController::class, 'show']);
        Route::delete('/toggle-status/{id}', [UnitController::class, 'toggleStatus']);
        Route::delete('/destroy/{id}', [UnitController::class, 'destroy']);
     });

      // Unit Routes....
      Route::group(['prefix'=>'/unit'], function() {
        Route::get('/list', [UnitController::class, 'list']);
        Route::get('/get-all', [UnitController::class, 'getAll']);
        Route::post('/store', [UnitController::class, 'store']);
        Route::put('/update/{id}', [UnitController::class, 'update']);
        Route::get('/show/{id}', [UnitController::class, 'show']);
        Route::delete('/toggle-status/{id}', [UnitController::class, 'toggleStatus']);
        Route::delete('/destroy/{id}', [UnitController::class, 'destroy']);
     });

    // Product Routes....
    Route::group(['prefix'=>'/product'], function() {
        Route::get('/list', [ProductController::class, 'list']);
        Route::get('/get-all', [ProductController::class, 'getAll']);
        Route::post('/store', [ProductController::class, 'store']);
        Route::put('/update/{id}', [ProductController::class, 'update']);
        Route::get('/show/{id}', [ProductController::class, 'show']);
        Route::delete('/toggle-status/{id}', [ProductController::class, 'toggleStatus']);
        Route::delete('/destroy/{id}', [ProductController::class, 'destroy']);
    });

});
