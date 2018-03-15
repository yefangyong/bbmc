<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/18
 * Time: 14:13
 */

namespace app\apiv1\model;


use think\Model;

class College extends Model
{
    /**
     * @return \think\model\relation\BelongsTo
     * 关联学校表
     */
    public function school() {
        return $this->belongsTo('School','sid','id');
    }
}