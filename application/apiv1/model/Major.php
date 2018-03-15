<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/18
 * Time: 14:24
 */

namespace app\apiv1\model;


use think\Model;

class Major extends Model
{
    /**
     * @return \think\model\relation\BelongsTo
     * 关联系部表
     */
    public function department() {
        return $this->belongsTo('Department','depart_id','id');
    }
}