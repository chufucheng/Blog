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
        $categoryList = Category::orderby('order','asc')->get()->toArray();
        //格式化分类数据
        $obj = new CategoryServers();
        $data = $obj->formateCategoryList($categoryList);
        return view('admin.category.categoryList',['data'=>$data]);
    }
    //更改排序
    public function changeCategory(Request $request)
    {
       $param = $request->input();
        $cateId = $param['cateId'];
        $order = $param['order'];
        if(empty($cateId) || empty($order)){
            return $this->jsonFromArray(['status'=>__LINE__,'msg'=>'排序或分类ID不能为空!']);
        }
        //更新排序
        $upOrderStatus = Category::where('id',$cateId)->update(['order'=>$order]);
        if($upOrderStatus === false){
            return $this->jsonFromArray(['status'=>__LINE__,'msg'=>'更新分类排序失败,请稍后重试!']);
        }
        return $this->jsonFromArray(['msg'=>'更新分类排序成功!']);
    }

}
