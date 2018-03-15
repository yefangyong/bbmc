<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/18
 * Time: 11:47
 */

namespace app\apiv1\controller\v1;


use app\api\validate\TokenGet;
use app\apiv1\model\Student;
use app\apiv1\service\Wx;
use think\Controller;

class User extends Controller
{
    /**
     * @param string $code
     * @return array
     * 获取用户的信息
     */
    public function getUserInfo($code = '') {
        (new TokenGet())->goCheck();
        $wx = new Wx($code);
        $openId = $wx->get();
        $student = Student::getStudentInfoByOpenID($openId);
        if($student) {
            return [
                'status'=>200,
                'time'=>$this->getDate(1519626468),//开学时间
                'is_bind'=>$student['is_bind'],
                'user'=>[
                'openid'=>$openId,
                'type'=>'学生',
                'more'=>$student,
                 ]
            ];
        }else {
            return [
                'status'=>200,
                'is_bind'=>0,
                'user'=>[
                    'openid'=>$openId
                ]
            ];
        }
    }

    /**
     * @param $startDate
     * @return array
     * 根据开学日期获取时间
     */
     function getDate($startDate) {
        $startDate1 = date('Y-m-d',$startDate);
        $today = date("Y-m-d",time());
        $weekInfo = $this->getweek($today);
        $day = ceil((time()-$startDate)/86400);
        $weekNum = ceil(($day+$weekInfo['startDay'])/7);
        $year = $weekInfo['year']+1;

        return [
            'term'=>$weekInfo['year'].'-'.$year.'学期',
            'week'=>$weekNum,
            'day'=>$weekInfo['week']
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

    /**
     * @param $openid
     * @param $uid
     * @param $pwd
     * @return array
     * 绑定用户
     */
    public function bind($openid,$uid,$pwd) {
        if(!isset($uid) || empty($uid)) {
            return [
                'status'=>401,
                'message'=>'请输入学号'
            ];
        }
        if(!isset($pwd) || empty($pwd)) {
            return [
                'status'=>401,
                'message'=>'请输入密码'
            ];
        }
        $student = Student::getStudentInfo($uid,$pwd);
        if(!$student) {
            return [
                'status'=>401,
                'message'=>'账号或者密码错误'
            ];
        }else {
            $uid = $student->id;
            $data = [
                'openid'=>$openid,
                'is_bind'=>1
            ];
            $rel = Student::update($data,['id'=>$uid]);
            if($rel) {
                return [
                    'status'=>200
                ];
            }else {
                return [
                    'status'=>401,
                    'message'=>'绑定失败'

                ];
            }
        }

    }


    /**
     * @param int $page
     * @param $type
     * @param $value
     * @return array
     * 学生查询根据类型
     */
  public function getUserByType($page=1,$type,$value) {
      $student = Student::getStudentByType($page,$type,$value);
      if($student->isEmpty()) {
          return [
              'status'=>401,
              'data'=>[],
              'message'=>'未找到相关的信息'
          ];
      }else {
          return [
              'status'=>200,
              'data'=>$student,
          ];
      }
  }

    /**
     * @param $uid
     * @param $build
     * @param $room
     * @return array
     * 完善用户的信息接口
     */
  public function setInfo($uid,$build,$room) {
      $data = [
          'build'=>$build,
          'room'=>$room
      ];
      $rel = Student::update($data,['uid'=>$uid]);
      if($rel) {
          return [
              'status'=>200,
              'message'=>'ok'
          ];
      }else {
          return [
              'status'=>401,
              'message'=>'保存失败'
          ];
      }
  }
}
