<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2018/11/6
 * Time: 14:50
 */

namespace app\commands;


use app\models\Common;
use app\models\GitRawWindBlog;
use app\models\JPGitWindblogSync;
use GuzzleHttp\Client;
use PHPHtmlParser\Dom;
use yii\console\Controller;
use yii\db\Exception;

class AutosyncController extends Controller
{

    public function actionIndex(){
        $GitRawWindBlog = new GitRawWindBlog();
        $gitUser = \Yii::$app->params['gitUser'];
        $Repositories = \Yii::$app->params['Repositories'];
        $url = "https://github.com/{$gitUser}/{$Repositories}/tree/gh-pages/_posts";

        $client = new \GuzzleHttp\Client(['base_uri' => $url]);
        $dom = new Dom();
        $response = $client->request('GET');
        if( $response->getStatusCode()=='200' ){
            $contents = trim($response->getBody()->getContents());
            preg_match("/<table.*?>(.*?)<\/table>/is",$contents,$content);
            $dom->load($content[0]);
            $lists = $dom->find('.js-navigation-item');
            try{
                foreach ($lists as $v){
                    $fileTag = $v->find('.js-navigation-open');
                    $markfile = $fileTag->text;
                    $tmp = explode('-',$markfile);
                    if( count($tmp)<=1 ) continue;
                    $href = $fileTag->href;//var_dump($v->innerHtml.'/n');var_dump($v->find('time-ago')->innerHtml);

                    //拉取最近限制天数的记录
                    $datetime = $v->find('.age span')->find('time-ago')->datetime;
                    $date = date("Y-m-d H:i:s",strtotime($datetime));
                    if( $date < date("Y-m-d 00:00:00",strtotime('-'.\Yii::$app->params['limitDays']." day")) ) continue;

                    //github RAW
                    $url_raw = "https://raw.githubusercontent.com{$href}";
                    $url_raw = str_replace("/blob","",$url_raw);
                    $raw = file_get_contents($url_raw ,NULL, NULL, 0, 150);Common::addLog('error.log',$raw);
                    $preg = "/---(.|\s?)*---(\s)/";
                    preg_match($preg,$raw,$match);
                    $tag = $match?$match[0]:Common::excepDeal("【{$url_raw}】没有设置标签信息");
                    if( !$tag ) continue;

                    //获取解析标签信息
                    $tags = $GitRawWindBlog->tagAnalysis($tag);

                    //添加队列服务
                    $fileData = ['url'=>$url_raw,'markfile'=>$markfile,'fileTime'=>$datetime];
                    JPGitWindblogSync::getInstance()->addGitServer( $fileData,$tags );
                }
            }catch (Exception $e){
                var_dump($e->getMessage());
                Common::addLog('error.log',print_r($e->getMessage(),1));
            }
        }
    }
}