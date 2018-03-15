<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/21
 * Time: 14:27
 */

namespace app\apiv1\model;


use think\Model;

class Course extends  Model
{
    protected $hidden = ['major_id','classroom_id','create_time','update_time','order'];

    public function getTypeAttr($value,$data) {
        if($value == 0) {
            return $value = '必修';
        }elseif($value == 1) {
            return $value = '选修';
        }
    }

    /**
     * @return \think\model\relation\BelongsTo
     * 关联老师表
     */
    public function teacher() {
        return $this->belongsTo('Teacher','teacher_id','id');
    }

    /**
     * @return \think\model\relation\BelongsTo
     * 关联教室表
     */
    public function classroom() {
        return $this->belongsTo('Classroom','classroom_id','id');
    }
    /**
     * @param $id
     * @return false|\PDOStatement|string|\think\Collection
     * 根据专业ID获取课程
     */
    public static function getCourseByMajorId($id) {
        return self::with(['teacher','classroom'])->where('major_id','=',$id)->order('week')->select();
    }
}