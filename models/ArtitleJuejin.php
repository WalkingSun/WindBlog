<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2018/12/18
 * Time: 18:14
 */

namespace app\models;


use PHPHtmlParser\Dom;

class ArtitleJuejin implements Article
{
    public function lists( $data=[] ){
        $result = [];
        $tag = !empty($data['tag'])?$data['tag']:'php';
        $dom = new Dom();
        $url = "https://segmentfault.com/t/{$tag}/blogs";
        $html = Common::httpGet($url);
        $dom->load($html);
        $info = $dom->find('.summary');
        if( $info ){

        }


        return $result;
    }

    public function analysis( $data=[] ){
        $result = [];

        return $result;
    }

    /**
     * 获取标签
     */
    public function getTag(){
        $result = [];
        $tagUrl = 'https://segmentfault.com/tags/all';
        $html = Common::httpGet($tagUrl);

        $dom = new Dom();
        $dom->load($html);

        $list = $dom->find('.tag-list__item');
        if($list){
            foreach ($list as $v){
                $result[] = $v.find('.h4').text;
            }
        }
        return $result;
    }
}