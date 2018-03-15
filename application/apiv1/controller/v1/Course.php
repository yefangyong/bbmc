<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/21
 * Time: 14:26
 */

namespace app\apiv1\controller\v1;


use app\apiv1\model\Ban;
use app\apiv1\model\Student;
use think\Controller;

class Course extends Controller
{

    public function getCourse($uid) {
        $student = Student::where('uid','=',$uid)->find();
        $class_id = $student->ban_id;
        $class = Ban::get($class_id);
        $major_id = $class->major_id;
        $courses =\app\apiv1\model\Course::getCourseByMajorId($major_id);
        $courses = $courses->toArray();
        $lessons = array_chunk($courses,5);
        foreach ($lessons as $k=>$v) {
            foreach ($v as $m=>$value) {
                $lessons[$k][$m]['teacher']=$value['teacher']['name'];
                $lessons[$k][$m]['place']=$value['classroom']['name'];
                $lessons[$k][$m]['weeks_data'] = explode(',',$value['weeks']);
                $lessons[$k][$m]['weeks'] = array();
                foreach ($lessons[$k][$m]['weeks_data'] as $value) {
                    $lessons[$k][$m]['weeks'][] = intval($value);
                }
                $lessons[$k][$m]['all_week'] = '';
                $lessons[$k][$m]['c_id'] =$lessons[$k][$m]['id'] ;//课程号
                foreach ($lessons[$k][$m]['weeks'] as $week) {
                    $lessons[$k][$m]['all_week'] =$lessons[$k][$m]['all_week']. ','.$week.'周';
                }
                unset($lessons[$k][$m]['week']);
                unset($lessons[$k][$m]['classroom']);
                $lessons[$k][$m]['all_week'] = mb_substr($lessons[$k][$m]['all_week'],1);
                $lessons[$k][$m] = array($lessons[$k][$m]);
            }
        }
        $date = $this->getDate(1504454400,time());
        $data = [
            'status'=>200,
            'message'=>'ok',
            'data'=>array('day'=>$date['day'],'week'=>$date['week'],'lessons'=>$lessons)
        ];
        return $data;

    }

    /**
     * @param $startDate
     * @return array
     * 根据开学日期获取时间
     */
    function getDate($startDate,$date) {
        $today = date("Y-m-d",$date);
        $weekInfo = $this->getweek($today);
        $day = ceil((time()-$startDate)/86400);
        $weekNum = ceil(($day+$weekInfo['startDay'])/7);
        $year = $weekInfo['year']+1;
        return [
            'term'=>$weekInfo['year'].'-'.$year.'学期',
            'week'=>$weekNum,
            'day'=>$weekInfo['startDay']
        ];
    }

    /**
     * @param $date1
     * @return array
     * 获取星期几
     */
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
            'year'=>$year,
            'month'=>$month
        ];
        return $week;
    }
}