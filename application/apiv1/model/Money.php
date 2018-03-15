<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/26
 * Time: 18:50
 */

namespace app\apiv1\model;


use think\Model;

class Money extends Model
{
    /**
     * @param $id
     * @return false|\PDOStatement|string|\think\Collection
     * 根据用户的ID获取一卡通的信息
     */
    public static function getMoney($id) {
        $data = [
            'uid'=>$id
        ];
        return self::where($data)->order('create_time desc')->limit(0,10)->select();
    }
}