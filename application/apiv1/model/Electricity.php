<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/27
 * Time: 14:11
 */

namespace app\apiv1\model;


use think\Model;

class Electricity extends Model
{
    public function elecRecord() {
        return $this->hasMany('Elec_Record','elec_id','id');
    }

    /**
     * @param $condition
     * @return false|\PDOStatement|string|\think\Collection
     * 获取用电的记录
     */
    public static function getElectricity($condition) {
        return self::with('elecRecord')->where($condition)->select();
    }
}