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
Route::group(['middleware' => 'web','namespace' => 'admin','prefix'=>'admin'], function () {
    Route::get('loginView','LoginController@loginView');//登录页面
    Route::post('login','LoginController@login');//登录
    Route::get('code','LoginController@code');//验证码生成
});

Route::group(['middleware' => ['web','admin.login'],'namespace' => 'admin','prefix'=>'admin'], function () {
    Route::get('Index','IndexController@Index');//后台主页
    Route::get('Info','IndexController@Info');//后台Info页面
    Route::get('loginOut','LoginController@loginOut');//用户退出登录
    Route::get('resetPassView','IndexController@resetPassView');//重置密码页面
    Route::post('resetPassword','IndexController@resetPassword');//重置密码
    Route::get('categoryList','CategoryController@categoryList');//分类列表
});
