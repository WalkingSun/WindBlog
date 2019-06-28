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
    use \app\models\HttpRequestTrait;

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
                $t = $v->find('.h4 a')->text;
                $result[$t] = ['id'=>$t,'name'=>$t];
            }
        }
        return $result;
    }

    public function pull():void{
        $data = [];
        $url = "https://segmentfault.com/u/jueze/bookmarks";

        $dom = new Dom();
        $dom->load( $this->httpGet($url) );
        $lists = $dom->find('.profile-mine__content li');
        if( $lists){
            foreach ( $lists as $v){
                $tagHref = $v->find('.profile-mine__content--title')->href;
                $tag = $v->find('.profile-mine__content--title')->text;
                $tagHref = 'https://segmentfault.com'.$tagHref;
                $articles = $this->httpGet($tagHref);
                $articles = $dom->load($articles);
                $article = $articles->find('.title');
                foreach ($article as $v1){
                    $v1=$v1->find('a');
                    $data[] = ['userId'=>'super','title'=>$v1->text,'content'=>'','href'=>'https://segmentfault.com'.$v1->href,'tag'=>$tag,'type'=>'','remark'=>'来源SegmentFault','createtime'=>date('Y-m-d H:i:s')];
                }
            }
        }

        $model_new =  new \app\models\JpKnowledgeRecovery;
        foreach ( $data as $v ){
            $model_new->saveData($v);
        }
    }
}