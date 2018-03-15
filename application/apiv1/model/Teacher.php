<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/21
 * Time: 15:12
 */

namespace app\apiv1\model;


use think\Model;

class Teacher extends  Model
{
    protected $hidden = ['sid','tel','sex','position_id','professional_id','sid','depart_id','college_id','create_time','id','update_time'];
}