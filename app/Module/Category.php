<?php

namespace App\Module;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';//表名
    protected $primaryKey = 'id';//主键ID
    //自动让系统使用 createdAt 和 updatedAt
    public $timestamps = false;
    //字段白名单
    protected $fillable = [
        'name'         //分类名称
        ,'title'       //标题
        ,'keyWords'    //关键字
        ,'description' //网页描述
        ,'view'        //浏览次数
        ,'order'       //排序
        ,'pid'         //父级ID
        ,'updatedAt'  //更新时间
        ,'createdAt'  //创建时间
    ];
}
