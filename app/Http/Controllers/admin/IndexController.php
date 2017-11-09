<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

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
}
