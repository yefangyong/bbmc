<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/18
 * Time: 12:02
 */

namespace app\apiv1\model;


use think\Model;

class Student extends Model
{
    public function getSexAttr($value,$data) {
        if($value == 0) {
            return $value = '男';
        }elseif($value == 1) {
            return $value = '女';
        }
    }
    /**
     * @return \think\model\relation\BelongsTo
     * 关联班级表
     */
    public function banji() {
        return $this->belongsTo('Ban','ban_id','id');
    }

    /**
     * @return \think\model\relation\BelongsTo
     * 关联年级表
     */
    public function grade() {
        return $this->belongsTo('Grade','grade_id','id');
    }
    /**
     * @param $openId
     * @return array|false|\PDOStatement|string|Model
     * 根据openID获取学生的信息
     */
    public static function getStudentInfoByOpenID($openId) {
        return self::with(['banji','grade','banji.major','banji.major.department','banji.major.department.college','banji.major.department.college.school'])->where('openid','=',$openId)->find();
    }

    /**
     * @param $uid
     * @param $pwd
     * @return array|false|\PDOStatement|string|Model
     * 根据账号和密码获取用户的信息
     */
    public static function getStudentInfo($uid,$pwd){
        $data = [
            'uid'=>$uid,
            'passwd'=>$pwd
        ];
        return self::where($data)->find();
    }

    /**
     * @param int $page
     * @param $type
     * @param $value
     * @return false|\PDOStatement|string|\think\Collection|\think\Paginator
     * 学生查询根据类型，分页
     */
    public static function getStudentByType($page = 1,$type,$value) {
        $data = array();
        if($type == 0) {
            $data['name']=array('like',$value."%");
            //根据学生的姓名查找，模糊查找，分页
            return self::with(['banji','grade','banji.major','banji.major.department','banji.major.department.college','banji.major.department.college.school'])->
            where($data)->
            paginate(config('student.rows'),false,['page'=>$page]);

        }elseif($type == 1) {
            //学生的学号
            $data['uid']=array('like',$value."%");
            return self::with(['banji','grade','banji.major','banji.major.department','banji.major.department.college','banji.major.department.college.school'])->
            where($data)->
            paginate(config('student.rows'),false,['page'=>$page]);
        }elseif ($type == 3) {
            //学生的班级
            return self::with(['banji','grade','banji.major','banji.major.department','banji.major.department.college','banji.major.department.college.school'])->where('class_id','=',$value)->select();
        }
    }

}