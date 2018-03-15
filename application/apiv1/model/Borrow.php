<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/27
 * Time: 10:05
 */

namespace app\apiv1\model;


use think\Model;

class Borrow extends Model
{
    /**
     * @return \think\model\relation\HasMany
     * 关联borrowBook表
     */
    public function bookList() {
        return $this->hasMany('BorrowBook','borrow_id','id');
    }

    /**
     * @param $uid
     * @return array|false|\PDOStatement|string|Model
     * 获取当前的借阅信息
     */
    public static function getBorrow($uid) {
        return self::with(['bookList','bookList.book'])->where('uid','=',$uid)->order('create_time desc')->select();
    }
}