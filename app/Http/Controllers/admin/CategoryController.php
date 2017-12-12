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
    //添加分类页面
    public function addCategoryView()
    {
        $pCate = Category::where('pid',0)->get();
        return view('admin.category.add',['data'=>$pCate]);
    }
    //添加分类
    public function addCategory(Request $request)
    {
        $param = $request->all();
        $rule = [
            'name' => 'required',
            'title' => 'required',
        ];
        $errorMsg = [
            'name.required'=>'分类名称不能为空!',
            'title.required'=>'标题不能为空!',
        ];
        //验证前段输入信息
        $validator = \Validator::make($param,$rule,$errorMsg);
        if($validator->passes()){
            $cateInfo = Category::where('name',$param['name'])->first();
            if(!empty($cateInfo)){//分类名称重复
                return redirect('admin/cate/addCategoryView')->with('msg','分类名称已存在不允许重复添加!');
            }
            //添加分类名称
            $data = [
                'name'        => $param['name'],
                'title'       => $param['title'],
                'keyWords'    => empty($param['keyWords']) ? '' : $param['keyWords'],
                'description' => empty($param['description']) ? '' : $param['description'],
                'order'       => empty($param['order']) ? 0 : $param['order'],
                'pid'         => empty($param['pid']) ? 0 : $param['pid'],
                'updatedAt'   => time(),
                'createdAt'   => time()
            ];
            $addStatus = Category::insertGetId($data);
            if(!$addStatus){//添加失败
                return redirect('admin/cate/addCategoryView')->with('msg','添加分类失败!');
            }else{//修改成功
                return redirect('admin/categoryList');
            }
        }else{
            return redirect('admin/cate/addCategoryView')->withErrors($validator);
        }
    }
}
