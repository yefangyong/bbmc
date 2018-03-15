<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/30
 * Time: 16:01
 */

namespace app\apiv1\model;


use think\Model;

class Article extends Model
{

    /**
     * @return \think\model\relation\HasMany
     * 关联附件表
     */
    public function fujian() {
        return $this->hasMany('Append','article_id','id');
    }
    /**
     * @param $type
     * @return false|\PDOStatement|string|\think\Collection
     * 根据类型获取文章
     */
    public static function getArticleByType($type) {
        if($type != 0) {
            $data = [
                'type'=>$type
            ];
        }else {
            $data = [];
        }
        return self::where($data)->limit(5)->order('create_time desc')->select();
    }

    /**
     * @param $type
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * 获取文章的详细信息
     */
    public static function getDetail($type,$id) {
        $data = [
            'type'=>$type,
            'id'=>$id
        ];
        return self::with('fujian')->where($data)->find();
     }
}