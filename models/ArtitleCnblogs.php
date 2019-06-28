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

    //拉取文章
    public function pull(){
        //获取超级用户的cnblog设置
        $blogConfig = JpBlogConfig::find()->where(['userId'=>'super','blogType'=>6])->asArray()->one();

        $blogMetaweblogUrl = Common::MetaweblogUrl($blogConfig['blogType'],$blogConfig['blogid']);
        $target = new MetaWeblog( $blogMetaweblogUrl );
        $target->setAuth( $blogConfig['username'],$blogConfig['password'] );

        if( $data = $target->check() ){
            $model_new =  new \app\models\JpKnowledgeRecovery;
            foreach ( $data[0] as $v ){
                $type = $v['categories']?implode(',',$v['categories']):'';

                $content = '';//(substr($v['description'],0,100));
                $up = ['userId'=>'super','title'=>$v['title'],'content'=>$content,'href'=>$v['link'],'tag'=>'','type'=>$type,'remark'=>'来源博客园','createtime'=>date('Y-m-d H:i:s') ];
                $model_new->saveData($up);
            }
        }
    }

}