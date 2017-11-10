<?php

namespace App\Module;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';//表名
    protected $primaryKey = 'id';//主键ID
    //自动让系统使用 createdAt 和 updatedAt
    public $timestamps = true;
    //字段白名单
    protected $fillable = [
        'name'     //用户名
        ,'password'     //用户名
        ,'updatedAt'  //更新时间
        ,'createdAt'  //创建时间
    ];
}
