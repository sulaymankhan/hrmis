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
    Route::post('employees',"EmployeesController@store");
   
});

Route::middleware(['auth','UserAccess:admin,manager,center_manager'])->group(function(){
    Route::get('employees/getStatusList','EmployeesController@getStatusList');
    Route::resource('employees', 'EmployeesController');
    Route::post('employees/updateStatus','EmployeesController@updateStatus');
    Route::get('employees','EmployeesController@index');
    Route::get("/villages",'OthersController@getVillages');
    Route::get('centers','CentersController@index');
    Route::put('employees',"EmployeesController@update");
    Route::post('changePassword','UsersController@changePassword');
    Route::resource('posts', 'PostController');
});

Route::post("/login","UsersController@login");
