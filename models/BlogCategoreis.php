<?php
/**
 * Created by PhpStorm.
 * User: MW
 * Date: 2018/7/26
 * Time: 10:25
 */

namespace app\models;


trait BlogCategoreis
{

    /**
     * 获取分类
     * @param $blogType            分类id
     * @param $blogUsername        用户名
     * @param $blogPassword         密码
     * @param $blogid              博客地址id
     * @param int $isCache          是否缓存
     * @return mixed                分类结果
     */
    public function get( $blogType,$blogUsername , $blogPassword ,$blogid, $isCache = 1 ){
        $result =[];
        $cache = \Yii::$app->cache;
        $key = $blogType.'_'.$blogUsername.'_'.$blogid;
        if( !$isCache || !$cache->exists($blogType.'_'.$blogUsername.'_'.$blogid) ){
            $blogMetaweblogUrl = Common::MetaweblogUrl($blogType,$blogid);
            $target = new MetaWeblog( $blogMetaweblogUrl );
            $username = $blogUsername;
            $passwd = $blogPassword;
            $target->setAuth( $username,$passwd );
            $Categories = $target->getCategories($blogid);
            if( empty($Categories[0]) ) return [];
            $result = $Categories[0];
            $cache->set($key,json_encode($result),60*60*24*30);
        }
        return $result?:json_decode($cache->get($key),1);
    }

}