<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

class LoginController extends CommonController
{
    //登录页面
    public function login(){
        return view('admin.login');
    }
}
