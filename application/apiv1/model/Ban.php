<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/18
 * Time: 14:10
 */

namespace app\apiv1\model;


use think\Model;

class Ban extends Model
{
    /**
     * @return \think\model\relation\BelongsTo
     * 关联系部表
     */
    public function major() {
        return $this->belongsTo('Major','major_id','id');
    }
}