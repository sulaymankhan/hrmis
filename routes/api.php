<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('admin')->middleware(['auth','UserAccess:admin,manager'])->group(function(){
    Route::resource('users','UsersController');
    Route::resource('centers','CentersController');
});

Route::middleware(['auth','UserAccess:admin,manager,center_manger'])->group(function(){
    Route::get('employees/getStatusList','EmployeesController@getStatusList');
    Route::post('employees/updateStatus','EmployeesController@updateStatus');
    Route::resource('employees','EmployeesController');
    Route::get("/villages",'OthersController@getVillages');
    Route::get('centers','CentersController@index');
    Route::post('changePassword','UsersController@changePassword');
});

Route::post("/login","UsersController@login");
