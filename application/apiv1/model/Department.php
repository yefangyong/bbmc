<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/18
 * Time: 14:12
 */

namespace app\apiv1\model;


use think\Model;

class Department extends Model
{
    /**
     * @return \think\model\relation\BelongsTo
     * 关联学院表
     */
    public function college() {
        return $this->belongsTo('College','college_id','id');
    }
}