<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{
    AuthController
};

Route::group(['prefix'=>'/auth', 'namespace' => 'Auth'], function() {

    Route::get('/role-wise-shop', [AuthController::class, 'roleWiseShop']);
    Route::get('/sidebar-menus/{role_id}/{shop_id}', [AuthController::class, 'sidebarMenus']);

});
