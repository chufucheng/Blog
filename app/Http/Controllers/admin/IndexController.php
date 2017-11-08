<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

class IndexController extends CommonController
{
    //后台住页面
    public function Index(){
        return view('admin/index');
    }
}
