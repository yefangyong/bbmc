<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/23
 * Time: 12:35
 */

namespace app\apiv1\controller\v1;


use app\apiv1\model\Student;
use app\apiv1\model\StudentExam;
use think\Controller;

class Exam extends Controller
{
    /**
     * @param $id
     * @return array
     * 根据用户的ID获取用户的课表信息
     */
    public function getExam($id){
        $student = Student::where('id','=',$id)->find();
        $exams = StudentExam::getExamByID($id);
        $exams = $exams->toArray();
        foreach ($exams as $k=>$exam) {
            $exams[$k]['number'] = $exam['setnum'];
            unset($exam['setnum']);
            $exams[$k]['type'] = $exam['exam'][0]['type'];
            unset($exam['exam'][0]['type']);
            $exams[$k]['date'] = date('Y-m-d',$exam['exam'][0]['start_time']);
            $date = $this->getDate(config('term.termData'),$exams[$k]['date']);
            $exams[$k]['time'] = date('H:m',$exam['exam'][0]['start_time']).'-'.date('H:m',$exam['exam'][0]['end_time']);
            $exams[$k]['days'] = $date['days'];
            $exams[$k]['day'] = $date['day'];
            $exams[$k]['week'] = $date['week'];
            $exams[$k]['username'] = $student->name;
            $exams[$k]['teacher'] = $exam['exam'][0]['course']['teacher']['name'];
            $exams[$k]['course'] = $exam['exam'][0]['course']['name'];
            $exams[$k]['room'] = $exam['exam'][0]['place'];
        }
        $data = [
            'status'=>200,
            'message'=>'ok',
            'data'=>$exams
        ];
        return $data;
    }

    /**
     * @param $startDate
     * @return array
     * 根据开学日期获取时间
     */
    function getDate($startDate,$date) {
        $today = date("Y-m-d",time());
        $weekInfo = $this->getweek($today);
        $examtime = $this->getweek($date);
        $day = ceil((strtotime($date)-$startDate)/86400);
        $weekNum = ceil(($day+$weekInfo['day'])/7);
        return [
            'week'=>$weekNum,
            'days'=>$examtime['days'],
            'day'=>$examtime['day']
        ];
    }

    /**
     * @param $date1
     * @return array
     * 获取星期几
     */
    function  getweek($date1) {
        $time = strtotime($date1);
        if($time == time()) {
            $days = 0;
        }else {
            $days = ceil(($time-time())/86400);
        }
        $datearr = explode("-",$date1);     //将传来的时间使用“-”分割成数组
        $year = $datearr[0];       //获取年份
        $month = sprintf('%02d',$datearr[1]);  //获取月份
        $day = sprintf('%02d',$datearr[2]);      //获取日期
        $hour = $minute = $second = 0;   //默认时分秒均为0
        $dayofweek = mktime($hour,$minute,$second,$month,$day,$year);    //将时间转换成时间戳
        $shuchu = date("w",$dayofweek);      //获取星期值
        $weekarray=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
        $week = [
            'day'=>$shuchu+1,
             'days'=>$days,
        ];
        return $week;
    }


    /**
     * @param $id
     * @return array
     * 根据ID获取成绩的信息
     */
    public function getGradeByID($id) {
       // $student = Student::where('id','=',$id)->find();
        //$entrance_time = $student->entrance_time;
        //$entrance_time = date('Y-m-d',$entrance_time);
        $year = date('Y',time());
        $years = $year+1;
        $term = $year.'-'.$years.'学年';
        $month = date('m',time());
        if(($month>=1 && $month<=2) || ($month>=9 && $month<=12)) {
            $term .= '第一学期';
        }elseif($month>2 && $month<9) {
            $term .='第二学期';
        }
        $grades = StudentExam::getGradeById($id);
        $grades = $grades->toArray();
        $data = array();
        foreach ($grades as $k=>$grade) {
            $data[$k]['course'] = $grade['exam'][0]['course']['name'];
            $data[$k]['grade'] = $grade['grade'];
            $data[$k]['term'] =$term;
        }
       return [
           'status'=>200,
           'message'=>'ok',
           'data'=>$data
       ];

    }
}