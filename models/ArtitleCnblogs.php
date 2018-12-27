<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2018/12/18
 * Time: 18:07
 */

namespace app\models;


class ArtitleCnblogs implements Article
{
    protected $homepageUrl = 'http://wcf.open.cnblogs.com/blog/sitehome/paged/{PAGEINDEX}/{PAGESIZE}';

    public function list( $data = [] ){
        $result = [];
        $pageindex = !empty($data['page'])?$data['page']:1;
        $pagesize = !empty($data['size'])?$data['size']:10;

        $url = str_replace ( ['{PAGEINDEX}','{PAGESIZE}'] ,  [$pageindex,$pagesize] ,  $this->homepageUrl );
        $response = Common::httpGet( $url );
        $xml = simplexml_load_string($response);
        $result['list'] = $this->analysis( $xml );
        $result['tag'] = [];
        return $result;
    }

    public function analysis( $data=[] ){
        $result = [];

        if( !empty($data->entry) ){
            $k = 0;
            foreach ($data->entry as $v){
                $v = (array)$v;
                $result[$k]['id'] = $v['id'];
                $result[$k]['title'] = $v['title'];
                $result[$k]['desc'] =  $v['summary'];
                $result[$k]['published'] = date('Y-m-d H:i',strtotime( $v['published'] ));
                $result[$k]['author'] = (array)$v['author'];
                $result[$k]['link'] = ((array)$v['link'])['@attributes']['href'];
                $result[$k]['diggs'] = $v['diggs'];
                $result[$k]['views'] = $v['views'];
                $result[$k]['comments'] = $v['comments'];
                $k++;
            }
        }
        return $result;
    }



}