<?php

/*
 * 分类处理
 */
namespace App\servers;


class CategoryServers
{
    //格式化分类数据
    public function formateCategoryList($data = [])
    {
        if(empty($data)){
            return false;
        }
        //分类分级
        $arr = [];
        foreach($data as $k=>$v){
            if($v['pid'] == 0){
                continue;
            }
            $v['name'] = '&nbsp;&nbsp;&nbsp;&nbsp;'.'┠━'.$v['name'];
            $arr[$v['pid']][] = $v;
        }
        //格式化分类数据
        $result = [];
        $i = 0;
        foreach($data as $key=>$value){
            if($value['pid'] == 0){
                $result[$i] = $value;
                $result[$i]['sonArr'] = array_key_exists($value['id'],$arr) ? $arr[$value['id']] : [];
                $i++;
            }
        }
        return $result;
    }
}