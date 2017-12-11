<?php

namespace App\Http\Controllers\admin;

use App\Module\Category;
use App\servers\CategoryServers;
use Illuminate\Http\Request;

class CategoryController extends CommonController
{
    //分类页面
    public function categoryList()
    {
        $categoryList = Category::all()->toArray();
        //格式化分类数据
        $obj = new CategoryServers();
        $data = $obj->formateCategoryList($categoryList);
        return view('admin.category.categoryList',['data'=>$data]);
    }
    //更改排序
    public function updateCategorysort(Request $request)
    {

    }

}
