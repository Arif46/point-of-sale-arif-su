<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Address\{ 
    DivisionController,
    DistrictController,
    CityCorporationController,
    UpazilaController,
    UnionController,
    WardController,
    PauroshovaController,
    BankController,
    BranchController
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
Route::group(['prefix'=>'/address', 'namespace' => 'Address'], function() {

    // Division Routes....
    Route::group(['prefix'=>'/division'], function() {
       Route::get('/list', [DivisionController::class, 'list']);
       Route::get('/get-all', [DivisionController::class, 'getAll']);
       Route::post('/store', [DivisionController::class, 'store']);
       Route::put('/update/{id}', [DivisionController::class, 'update']);
       Route::get('/show/{id}', [DivisionController::class, 'show']);
       Route::delete('/toggle-status/{id}', [DivisionController::class, 'toggleStatus']);
       Route::delete('/destroy/{id}', [DivisionController::class, 'destroy']);
   });

   // District Routes....
    Route::group(['prefix'=>'/district'], function() {
        Route::get('/list', [DistrictController::class, 'list']);
        Route::get('/get-all', [DistrictController::class, 'getAll']);
        Route::post('/store', [DistrictController::class, 'store']);
        Route::put('/update/{id}', [DistrictController::class, 'update']);
        Route::get('/show/{id}', [DistrictController::class, 'show']);
        Route::delete('/toggle-status/{id}', [DistrictController::class, 'toggleStatus']);
        Route::delete('/destroy/{id}', [DistrictController::class, 'destroy']);
    });

    // Upazilla Routes....
    Route::group(['prefix'=>'/upazilla'], function() {
        Route::get('/list', [UpazilaController::class, 'list']);
        Route::get('/get-all', [UpazilaController::class, 'getAll']);
        Route::post('/store', [UpazilaController::class, 'store']);
        Route::put('/update/{id}', [UpazilaController::class, 'update']);
        Route::get('/show/{id}', [UpazilaController::class, 'show']);
        Route::delete('/toggle-status/{id}', [UpazilaController::class, 'toggleStatus']);
        Route::delete('/destroy/{id}', [UpazilaController::class, 'destroy']);
    });

    // Union Routes....
    Route::group(['prefix'=>'/union'], function() {
        Route::get('/list', [UnionController::class, 'list']);
        Route::get('/get-all', [UnionController::class, 'getAll']);
        Route::post('/store', [UnionController::class, 'store']);
        Route::put('/update/{id}', [UnionController::class, 'update']);
        Route::get('/show/{id}', [UnionController::class, 'show']);
        Route::delete('/toggle-status/{id}', [UnionController::class, 'toggleStatus']);
        Route::delete('/destroy/{id}', [UnionController::class, 'destroy']);
    });

    // Ward Routes....
    Route::group(['prefix'=>'/ward'], function() {
        Route::get('/list', [WardController::class, 'list']);
        Route::get('/get-all', [WardController::class, 'getAll']);
        Route::post('/store', [WardController::class, 'store']);
        Route::put('/update/{id}', [WardController::class, 'update']);
        Route::get('/show/{id}', [WardController::class, 'show']);
        Route::delete('/toggle-status/{id}', [WardController::class, 'toggleStatus']);
        Route::delete('/destroy/{id}', [WardController::class, 'destroy']);
    });

     //City Corporation Routes....
     Route::group(['prefix'=>'/cityCorporation'], function() {
        Route::get('/list', [CityCorporationController::class, 'list']);
        Route::get('/get-all', [CityCorporationController::class, 'getAll']);
        Route::post('/store', [CityCorporationController::class, 'store']);
        Route::put('/update/{id}', [CityCorporationController::class, 'update']);
        Route::get('/show/{id}', [CityCorporationController::class, 'show']);
        Route::delete('/toggle-status/{id}', [CityCorporationController::class, 'toggleStatus']);
        Route::delete('/destroy/{id}', [CityCorporationController::class, 'destroy']);
    });

    // Pauroshova Routes....
    Route::group(['prefix'=>'/pauroshova'], function() {
        Route::get('/list', [PauroshovaController::class, 'list']);
        Route::get('/get-all', [PauroshovaController::class, 'getAll']);
        Route::post('/store', [PauroshovaController::class, 'store']);
        Route::put('/update/{id}', [PauroshovaController::class, 'update']);
        Route::get('/show/{id}', [PauroshovaController::class, 'show']);
        Route::delete('/toggle-status/{id}', [PauroshovaController::class, 'toggleStatus']);
        Route::delete('/destroy/{id}', [PauroshovaController::class, 'destroy']);
    });

     // Bank Routes....
     Route::group(['prefix'=>'/bank'], function() {
        Route::get('/list', [BankController::class, 'list']);
        Route::get('/get-all', [BankController::class, 'getAll']);
        Route::post('/store', [BankController::class, 'store']);
        Route::put('/update/{id}', [BankController::class, 'update']);
        Route::get('/show/{id}', [BankController::class, 'show']);
        Route::delete('/toggle-status/{id}', [BankController::class, 'toggleStatus']);
        Route::delete('/destroy/{id}', [BankController::class, 'destroy']);
    });

     // Branch Routes....
     Route::group(['prefix'=>'/branch'], function() {
        Route::get('/list', [BranchController::class, 'list']);
        Route::get('/get-all', [BranchController::class, 'getAll']);
        Route::post('/store', [BranchController::class, 'store']);
        Route::put('/update/{id}', [BranchController::class, 'update']);
        Route::get('/show/{id}', [BranchController::class, 'show']);
        Route::delete('/toggle-status/{id}', [BranchController::class, 'toggleStatus']);
        Route::delete('/destroy/{id}', [BranchController::class, 'destroy']);
    });

});
