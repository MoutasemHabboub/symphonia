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
Route::post('login', 'api\TeacherController@login');
Route::post('register', 'api\TeacherController@register');
Route::post('addSpecialization', 'api\SpecializationController@addSpecialization');

Route::group(['middleware' => ['auth:api', 'twofactor']],function(){
    Route::post('details', 'api\TeacherController@details');
    Route::post('registerTeacher', 'api\TeacherController@registerTeacher');

});
