<?php
/**
 * Created by PhpStorm.
 * User: cpx
 * Date: 2017/11/10
 * Time: 10:29
 */
class Fun{
    //去除空格
    public static function array_trim($array,$replace = false, $from =',',$to = ''){
        if($replace){
            array_walk_recursive($array, function(&$item)use($from,$to){
                $str = str_replace($from,$to,trim($item));
                if( is_numeric($str) ){
                    $item = $str;
                }else{
                    $item = trim($item);
                }
            });
        }else{
            array_walk_recursive($array, function(&$item){
                $item = trim($item);
            });
        }
        return $array;
    }
    //金额转大写
    public static function cny($num) {
        $c1 = "零壹贰叁肆伍陆柒捌玖";
        $c2 = "分角圆拾佰仟万拾佰仟亿";
        //精确到分后面就不要了，所以只留两个小数位
        $num = round($num, 2);
        //将数字转化为整数
        $num = bcmul($num , 100,0);

        if(fmod($num,100) == 0){
            $end = '圆整';
        }else{
            $end = '';
        }

        if (strlen($num) > 10) {
            return "金额太大，请检查";
        }
        $i = 0;
        $c = "";
        while (1) {
            if ($i == 0) {
                //获取最后一位数字
                $n = substr($num, strlen($num)-1, 1);
            } else {
                $n = $num % 10;
            }
            //每次将最后一位数字转化为中文
            $p1 = substr($c1, 3 * $n, 3);
            $p2 = substr($c2, 3 * $i, 3);
            if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
                $c = $p1 . $p2 . $c;
            } else {
                $c = $p1 . $c;
            }
            $i = $i + 1;
            //去掉数字最后一位了
            $num = $num / 10;
            $num = intval($num);

            //结束循环
            if ($num == 0) {
                break;
            }
        }
        $j = 0;
        $slen = strlen($c);
        while ($j < $slen) {
            //utf8一个汉字相当3个字符
            $m = substr($c, $j, 6);
            //处理数字中很多0的情况,每次循环去掉一个汉字“零”
            if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
                $left = substr($c, 0, $j);
                $right = substr($c, $j + 3);
                $c = $left . $right;
                $j = $j-3;
                $slen = $slen-3;
            }
            $j = $j + 3;
        }
        //这个是为了去掉类似23.0中最后一个“零”字
        if (substr($c, strlen($c)-3, 3) == '零') {
            $c = substr($c, 0, strlen($c)-3);
        }

        //将处理的汉字加上“整”
        if (empty($c)) {
            return "零圆整";
        }else{
            if(mb_substr($c,-1,1,'utf-8') == '圆'){
                $end = "整";
            }
            return $c . $end;
        }
    }
    /**
     * 获取指定月份的第一天开始和最后一天结束的时间戳
     *
     * @param int $y 年份
     * @param int $m 月份
     *
     * @return array (本月开始时间，本月结束时间)
     */
    public static function monthStartEnd($y, $m)
    {
        if ($y == '') $y = date('Y');
        if ($m == '') $m = date('m');
        $m = sprintf('%02d', intval($m));
        $y = str_pad(intval($y), 4, '0', STR_PAD_RIGHT);

        $m > 12 || $m < 1 ? $m = 1 : $m = $m;
        $firstDay = strtotime($y . $m . '01000000');
        $firstDayStr = date('Y-m-01', $firstDay);
        $lastDay = strtotime(date('Y-m-d 23:59:59', strtotime("$firstDayStr +1 month -1 day")));
        return ['firstDay' => $firstDay, 'lastDay' => $lastDay];
    }
    //将对象转换为数组
    public static function objectToArray($e)
    {
        $e = (array)$e;
        foreach ($e as $k => $v) {
            if (gettype($v) == 'resource') return;
            if (gettype($v) == 'object' || gettype($v) == 'array')
                $e[$k] = (array)Fun::objectToArray($v);
        }
        return $e;
    }
    //计算两个日期中间间隔的天数 包含这两个日期在内的天数
    public static function diffBetweenTwoDays ($day1, $day2)
    {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);

        if ($second1 < $second2) {
            list($second1,$second2) = [$second2,$second1];
        }
        return ($second1 - $second2) / 86400 + 1;
    }

}