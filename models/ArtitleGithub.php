<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2018/12/18
 * Time: 18:14
 */

namespace app\models;


use PHPHtmlParser\Dom;

class ArtitleGithub implements Article
{
    use \app\models\HttpRequestTrait;

    public function list( $data=[] ){
        $result = [];

        return $result;
    }

    public function analysis( $data=[] ){
        $result = [];

        return $result;
    }

    public function pull( $url ){
        $GitRawWindBlog = new GitRawWindBlog();
        try{
            $dom = new Dom();
            $dom = $dom->loadFromUrl($url);
            $dom = $dom->find('.Details-content--hidden-not-important');
            $lists = $dom->find('.js-navigation-item');
            foreach ($lists as $v) {
                $fileTag = $v->find('.js-navigation-open');
                $markfile = $fileTag->text;
                if( $markfile=='..' || $markfile=="  " ) continue;

                //匹配到文件夹再次查询
                $ariaLabel = $v->find('svg');
                $ariaLabel = array_values(((array)$ariaLabel->tag));
                $ariaLabel = $ariaLabel[1]['aria-label']['value'];
                if( $ariaLabel && $ariaLabel == 'Directory' ){
                    $this->pull($url.'/'.$markfile);
                    continue;
                }

                $tmp = explode('-',$markfile);
                if( count($tmp)<=1 ) continue;
                $href = $fileTag->href;

                //拉取最近限制天数的记录
                $datetime = $v->find('.text-gray-light')->find('time-ago')->datetime;
                $datetime = date("Y-m-d H:i:s",strtotime($datetime));
                if( $datetime < date("Y-m-d 00:00:00",strtotime('-'.\Yii::$app->params['limitDays']." day")) ) continue;

                //github RAW
                $url_raw = "https://raw.githubusercontent.com{$href}";

                $url_raw = str_replace("/blob","",$url_raw);
                $raw = file_get_contents($url_raw ,NULL, NULL, 0, 500);

                $t = explode('---',$raw);
//                    $preg = "/---(.|\s?)*---(\s)/";
//                    preg_match($preg,$raw,$match);
//                    $tag = $match?$match[0]:Common::excepDeal("【{$url_raw}】没有设置标签信息");

                $tag =$t[1]??Common::excepDeal("【{$url_raw}】没有设置标签信息");
                if( !$tag ) continue;

                //获取解析标签信息
                $tags = $GitRawWindBlog->tagAnalysis($tag);

                //添加队列服务
                $fileData = ['url'=>$url_raw,'markfile'=>$markfile,'fileTime'=>$datetime];

                //跳过草稿
                if( !(strrpos($tags['title'],'draft')===false) ) continue;

                JPGitWindblogSync::getInstance()->addGitServer( $fileData,$tags );

                Common::addLog('error.log',"{$tags['title']} 同步成功");

                sleep(1);
            }
        }catch (\Exception $e){
            var_dump($e->getMessage());
            Common::addLog('error.log',$tags['title'] .' 同步失败 ' . print_r($e->getMessage(),1));
        }
    }
}