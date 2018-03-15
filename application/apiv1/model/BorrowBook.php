<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/27
 * Time: 10:05
 */

namespace app\apiv1\model;


use think\Model;

class BorrowBook extends Model
{
    /**
     * @return \think\model\relation\HasOne
     * 关联book表
     */
    public function book() {
        return $this->hasOne('Book','id','book_id');
    }
}