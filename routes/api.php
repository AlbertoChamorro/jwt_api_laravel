<?php

use Illuminate\Http\Request;

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

Route::apiResource('products', 'ProductController');

Route::post('signup', 'AuthController@register');

Route::post('login', 'AuthController@login');

Route::group(['prefix' => 'auth', 'middleware' => 'jwt.auth'], function () {
    Route::get('userProfile', 'AuthController@userProfile');
    Route::post('logout', 'AuthController@logout');
});

Route::middleware('jwt.refresh')->get('/token/renew', 'AuthController@renewToken');
