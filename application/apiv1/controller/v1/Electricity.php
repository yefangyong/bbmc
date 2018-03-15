<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/27
 * Time: 14:06
 */

namespace app\apiv1\controller\v1;


use think\Controller;

class Electricity extends Controller
{
    /**
     * @param $build
     * @param $room
     * @return array
     * 获取用电的相关的信息
     */
    public function getElectricity($build,$room)
    {
        $condition = [
            'build' => $build,
            'room' => $room
        ];
        $elec = \app\apiv1\model\Electricity::getElectricity($condition);
        $elec = $elec->toArray();
        $month = date('m', time());
        $time = date('Y-m-d', time());
        $record = array();
        foreach ($elec as $k => $v) {
            foreach ($v['elec_record'] as $m => $n) {
                if ($n['month'] == $month) {
                    $record = $v['elec_record'][$m];
                }
            }
        }
        $data = [
            'info'=>$record,
            'time'=>$time
        ];
        if ($record) {
            return [
                'data'=>$data,
                'message'=>'ok',
                'status'=>200
            ];
        }else {
            return [
                'status'=>401,
                'message'=>'暂无数据'
            ];
        }
    }
}