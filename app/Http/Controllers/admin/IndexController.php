<?php

namespace App\Http\Controllers\admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

class IndexController extends CommonController
{
    //后台主页面
    public function Index(){
        return view('admin/index');
    }
    //加载Info页面
    public function Info(){
        return view('admin/info');
    }
    //修改密码页面
    public function resetPassView(){
        return view('admin/pass');
    }
    //修改密码
    public function resetPassword(Request $request){
        $param = Input::all();
        if (!empty($param)){
            $rule = [
                'password' => 'required|between:6,12|confirmed'
            ];
            $errorMsg = [
                'password.required'=>'新密码不能为空!',
                'password.between'=>'新密码必须为6-20位!'
            ];
            $validator = \Validator::make($param,$rule,$errorMsg);
            $validator->passes();
            dd($validator->errors()->all());
        }else{
            return redirect('admin/resetPassView');
        }
    }
}
