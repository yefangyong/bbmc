<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/21
 * Time: 15:12
 */

namespace app\apiv1\model;


use think\Model;

class Classroom extends  Model
{
    protected  $hidden = ['create_time','update_time','sid'];
}