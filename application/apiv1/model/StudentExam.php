<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/23
 * Time: 12:47
 */

namespace app\apiv1\model;


use think\Model;

class StudentExam extends Model
{
    public $hidden = ['create_time','update_time','uid','exam_id'];
    /**
     * @return \think\model\relation\HasMany
     * 关联考试表
     */
    public function exam() {
        return $this->hasMany('Exam','id','exam_id');
    }
    /**
     * @param $uid
     * @return false|\PDOStatement|string|\think\Collection
     * 获取课表信息
     */
    public static function getExamByID($uid) {
        return self::with(['exam.course.classroom','exam','exam.course','exam.course.teacher'])->where('uid','=',$uid)->select();
    }

    /**
     * @param $id
     * @return false|\PDOStatement|string|\think\Collection
     * 根据ID获取成绩
     */
    public static function getGradeById($id) {
        $data = [
            'uid'=>$id,
            'status'=>1
        ];
        return self::with(['exam.course.classroom','exam','exam.course','exam.course.teacher'])->where($data)->select();
    }
}