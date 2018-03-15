<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/23
 * Time: 12:39
 */

namespace app\apiv1\model;


use think\Model;

class Exam extends Model
{
    protected  $hidden = ['create_time','update_time'];
    public function getTypeAttr($value,$data) {
        if($value == 0) {
            return $value = '期末';
        }else {
            return $value = '期中';
        }
    }
    /**
     * @return \think\model\relation\BelongsTo
     * 关联课程表
     */
    public function course() {
        return $this->belongsTo('Course','course_id','id');
    }


    /**
     * @return \think\model\relation\HasOne
     * 关联教室表
     */
    public function place() {
        return $this->hasOne('Classroom','id','place_id');
    }
}