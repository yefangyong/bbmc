<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/30
 * Time: 16:00
 */

namespace app\apiv1\controller\v1;


use think\Controller;

class Article extends Controller
{
    /**
     * @param $type
     * @return array
     * 根据type来获取文章的数据
     */
    public function getArticleByType($type) {
        $articles = \app\apiv1\model\Article::getArticleByType($type);
        $articles = $articles->toArray();
        foreach ($articles as $k=> $article) {
            if($article['type'] == 1) {
                $articles[$k]['type'] = 'jw';
            }elseif($article['type'] == 2) {
                $articles[$k]['type'] = 'oa';
            }elseif($article['type'] == 3) {
                $articles[$k]['type'] = 'hy';
            }elseif($article['type'] == 4) {
                $articles[$k]['type'] = 'jz';
            }elseif($article['type'] == 5) {
                $articles[$k]['type'] = 'new';
            }
            $articles[$k]['create_time'] = mb_substr($article['create_time'],0,10);
        }
        return [
            'status'=>200,
            'data'=>$articles,
            'message'=>'ok'
        ];
    }

    /**
     * @param $type
     * @param $id
     * @return array
     * 获取文章的详细信息
     */
    public function getDetail($type,$id) {
        if($type == 'jw') {
            $type = 1;
        }elseif($type == 'oa') {
            $type = 2;
        }elseif($type == 'hy') {
            $type = 3;
        }elseif ($type == 'jz') {
            $type =4;
        }elseif ($type == 'new') {
            $type = 5;
        }
        $article = \app\apiv1\model\Article::getDetail($type,$id);
        $article = $article->toArray();
        $article['create_time'] = mb_substr($article['create_time'],0,10);
        if($article) {
            return [
                'status'=>200,
                'data'=>$article,
                'message'=>'ok'
            ];
        }else {
            return [
                'status'=>401,
                'data'=>'',
                'message'=>'该文章不存在'
            ];
        }
    }
}