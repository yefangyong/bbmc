<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/27
 * Time: 10:04
 */

namespace app\apiv1\controller\v1;


use app\apiv1\model\Student;
use think\Controller;

class Borrow extends Controller
{
    /**
     * @param $uid
     * @return array
     * 获取用户的借阅信息
     */
    public function getBorrow($uid) {
        $student = Student::get(['uid'=>$uid]);
        $dbet = $student->dbet;
        $borrow = \app\apiv1\model\Borrow::getBorrow($uid);
        $history_count = 0;
        $borrow = $borrow->toArray();
        foreach ($borrow as $k=> $v) {
            $history_count += count($v['book_list']);
            foreach ($v['book_list'] as $m=>$n) {
                $borrow[$k]['book_list'][$m]['jyrq'] = date('Y-m-d', $borrow[$k]['book_list'][$m]['jyrq']);
                $borrow[$k]['book_list'][$m]['yhrq'] = date('Y-m-d', $borrow[$k]['book_list'][$m]['yhrq']);
                $borrow[$k]['book_list'][$m]['book'] = $borrow[$k]['book_list'][$m]['book']['name'];
            }
        }
        $book = $borrow[0];
        $now_count = count($book['book_list']);
        $book_list = $book['book_list'];

        return [
            'status'=>200,
            'message'=>'ok',
            'data'=>[
                'books_num'=>$now_count,
                'history'=>$history_count,
                'dbet'=>$dbet,
                'book_list'=>$book_list,
            ]
        ];

    }
}