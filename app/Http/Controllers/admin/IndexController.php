<?php

namespace App\Http\Controllers\admin;

use App\Module\Admin;
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
                'adminName' => 'required',
                'password' => 'required|between:6,12|confirmed'
            ];
            $errorMsg = [
                'adminName.required'=>'用户名不能为空!',
                'password.required'=>'新密码不能为空!',
                'password.between'=>'新密码必须为6-20位!',
                'password.confirmed'=>'新密码与确认密码不匹配!',
            ];
            //验证前段输入信息
            $validator = \Validator::make($param,$rule,$errorMsg);
            if($validator->passes()){
                $AdminInfo = Admin::where('name',$param['adminName'])->first();
                if(empty($AdminInfo)){//用户不存在
                    return redirect('admin/resetPassView')->with('msg','该用户不存在请确认后重新输入!');
                }
                if($param['password_o'] != Crypt::decrypt($AdminInfo->password)){ //原密码与数据库原密码不相同
                    return redirect('admin/resetPassView')->with('msg','原密码输入有误不允许修改!');
                }else{
                    //修改用户密码
                    $newPass = Crypt::encrypt($param['password']);
                    $upStatus = Admin::where('name',$param['adminName'])->update(['password'=>$newPass,'updatedAt'=>time()]);
                    if($upStatus === false){//修改失败
                        return redirect('admin/resetPassView')->with('msg','修改密码失败!');
                    }else{//修改成功
                        return redirect('admin/Info');
                    }
                }
            }else{
                return redirect('admin/resetPassView')->withErrors($validator);
            }
        }else{
            return redirect('admin/resetPassView');
        }
    }
}
