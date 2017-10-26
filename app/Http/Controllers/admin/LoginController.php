<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    //登录页面
    public function login(){
        return view('admin.login');
    }

    //验证码
    public function code(){
        $code = new \Code;
        $code->make();
    }
    //获取验证码
    public function getCode(){
        $code = new \Code;
        echo $code->get();
    }
}
