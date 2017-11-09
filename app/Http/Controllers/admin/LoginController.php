<?php

namespace App\Http\Controllers\admin;

use App\Module\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    //登录页面
    public function loginView(){
        return view('admin.login');
    }
    //用户登录
    public function login(Request $request){
        $param = Input::all();
        if(!empty($param)){
            //判断验证码是否正确
            $codeClass = new \Code;
            $code = $codeClass->get();
            if(strtoupper($param['code']) != $code){
                return back()->with('msg','验证码错误');
            }
            //判断用户名及密码
            $adminInfo = Admin::where('name',$param['username'])->first();
            if(empty($adminInfo)){
                return back()->with('msg','该用户不存在请重新输入');
            }elseif($adminInfo->name != $param['username']){
                return back()->with('msg','您输入的用户名有误在请重新输入');
            }elseif($param['password'] != Crypt::decrypt($adminInfo->password)){
                return back()->with('msg','您输入的用户密码有误在请重新输入');
            }else{
                //将登录的用户写入session中
                session(['admin'=>$adminInfo]);
                return redirect('admin/Index');
            }
        }else{
            return view('admin.login');
        }
    }

    //用户退出
    public function loginOut(){
        session(['admin'=>null]);
        return redirect('admin/loginView');
    }

    //验证码
    public function code(){
        $code = new \Code;
        $code->make();
    }
}
