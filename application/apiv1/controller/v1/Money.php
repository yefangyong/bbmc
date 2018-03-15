<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/26
 * Time: 18:47
 */

namespace app\apiv1\controller\v1;


use think\Controller;

class Money extends Controller
{
    public function getMoney($id) {
        $money = \app\apiv1\model\Money::getMoney($id);
        return [
            'data'=>$money,
            'message'=>'ok',
            'status'=>200
        ];
    }
}