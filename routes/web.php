<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
Route::group(['middleware' => 'web','namespace' => 'admin'], function () {
    Route::get('admin/login','LoginController@login');//登录页面
    Route::get('admin/code','LoginController@code');//验证码生成
    Route::get('admin/getCode','LoginController@getCode');//验证码生成
});
