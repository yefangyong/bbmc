<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        header("Content-type: text/html; charset=utf-8");
        $this->getDate(1504454400);
    }

    public function getDate($startDate) {
        $startDate1 = date('Y-m-d',$startDate);
        $weekInfo = $this->getweek($startDate1);
        $day = ceil((time()-$startDate)/86400);
        echo ceil(($day+$weekInfo['startDay'])/7);

    }

    function  getweek($date1) {
        $datearr = explode("-",$date1);     //将传来的时间使用“-”分割成数组
        $year = $datearr[0];       //获取年份
        $month = sprintf('%02d',$datearr[1]);  //获取月份
        $day = sprintf('%02d',$datearr[2]);      //获取日期
        $hour = $minute = $second = 0;   //默认时分秒均为0
        $dayofweek = mktime($hour,$minute,$second,$month,$day,$year);    //将时间转换成时间戳
        $shuchu = date("w",$dayofweek);      //获取星期值
        $weekarray=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
        $week = [
            'startDay'=>$shuchu,
            'week'=>$weekarray[$shuchu],
            'year'=>$year
        ];
        return $week;
    }
}