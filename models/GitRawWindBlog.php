<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2018/11/14
 * Time: 11:35
 */

namespace app\models;


class GitRawWindBlog
{

    /**
     * 处理格式如：
        ---
        layout: post
        title: Linux命令
        categories: [linux]
        description:
        keywords: linux
        cnblogsClass: [Markdown],[随笔分类]Java,[随笔分类]JS or HTML,[随笔分类]PHP,[随笔分类]YII,[随笔分类]服务器,[随笔分类]技术集锦,[随笔分类]架构,[随笔分类]容器,[随笔分类]数据库,[随笔分类]网络协议,[随笔分类]微信,[随笔分类]遇到问题,[发布为日记],[发布为文章],[发布为新闻]
        oschinaClass: PHP,数据库,服务器,工作日志,,日常记录,转贴的文章
     * ---
     *
     * @param string $content GitHub RAW 标签解析
     * @return array|bool
     */
    public function tagAnalysis( $content='' ){
        if( !$content ) return false;
        $content = trim($content,'---');
        $token = strtok($content, "\n");

        $result = [];
        while ($token !== false)
        {
            $tt = explode(":",$token);
            if( count($tt)>1 ){
                $result[trim($tt[0])] = trim($tt[1]);
            }
            $token = strtok("\n");
        }
        return $result;
    }

}