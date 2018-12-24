<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2018/12/18
 * Time: 18:14
 */

namespace app\models;


use PHPHtmlParser\Dom;

class ArtitleSegment implements Article
{
    public function list( $data=[] ){
        $result = [];
        $tag = !empty($data['tag'])?$data['tag']:'php';
        $dom = new Dom();
        $url = "https://segmentfault.com/t/{$tag}/blogs";
        $html = Common::httpGet($url);
        $dom->load($html);
        $info = $dom->find('.summary');

        $result['list'] = $this->analysis($info);
        $result['tag'] = $this->getTag();

        return $result;
    }

    public function analysis( $data=[] ){
         $result = [];
         if( $data ){
             $k=0;
             foreach ($data as $v){
                 $result[$k]['title'] = $v->find('.title a')->text;
                 $result[$k]['link'] = 'https://segmentfault.com'.$v->find('.title a')->href;
                 $result[$k]['published'] = '';
                 if(  $t = $v->find('.author')->find('li span')->text ){
                     $tt = explode(' ',trim($t));
                     $result[$k]['published'] = $tt[0].$tt[1];
                 }
                 $result[$k]['author']['name'] = $v->find('.author')->find('li span a')->text;
                 $result[$k]['author']['uri'] = 'https://segmentfault.com'.$v->find('.author')->find('li span a')->href;
                 $result[$k]['diggs'] = 0;
                 if(  $t =  $v->find('.author')->find('.bookmark')->title ){
                     $tt = explode(' ',$t);
                     $result[$k]['diggs'] = $tt[0];
                 }
                 $k++;
             }
         }

        return $result;
    }

    /**
     * 获取标签
     */
    public function getTag(){
        $result = [];
        //todo 分页查询，结果缓存
        $tagUrl = 'https://segmentfault.com/tags/all';
        $html = Common::httpGet($tagUrl);

        $dom = new Dom();
        $dom->load($html);

        $list = $dom->find('.widget-tag');
        if($list){
            foreach ($list as $v){
                $result[] = $v->find('.h4 a')->text;
            }
        }
        return $result;
    }
}