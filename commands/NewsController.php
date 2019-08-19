<?php
/**
 * Created by PhpStorm.
 * User: zhaoyu
 * Date: 2019/7/19
 * Time: 1:36 PM
 */

namespace app\commands;


use app\models\Common;
use yii\console\Controller;

/**
 * 抓取新闻头条
 * Class NewsController
 * @package app\commands
 */
class NewsController extends Controller
{

    public function actionTop(){

        $top_time = date('Ymd');
        $top_show_num = 3;
        $entNews = $this->getNews('http://top.ent.sina.com.cn','ent_suda',$top_time,10);  //娱乐头条
        $news = $this->getNews('http://top.news.sina.com.cn','www_www_all_suda_suda',$top_time,5);  //综合新闻
//        $news1 = $this->getNews('http://top.news.sina.com.cn','news_society_suda',$top_time,$top_show_num);   //社会新闻
//        $news2 = $this->getNews('http://top.news.sina.com.cn','news_mil_suda',$top_time,2);       //军事新闻
        $news2 = $this->getNews('http://top.tech.sina.com.cn','tech_news_suda',$top_time,$top_show_num);       //科技新闻

        $news_product = $this->getProductNews($top_show_num);

        $newMsg = "新闻早班车\r\n\r\n";
        $entNewMsg = "明姐爱看的八卦\r\n\r\n";
        $eamilMsg = '';
        if( $news ){
            if( !empty($news1) ) $news['data'] = array_merge($news['data'],$news1['data']);
            if( $news2 ) $news['data'] = array_merge($news['data'],$news2['data']);
            if( !empty($news_product) ) $news['data'] = array_merge($news['data'],$news_product);

            foreach ($news['data'] as $v){
                $newMsg .= "{$v['title']}\r\n{$v['url']}\r\n\r\n";
                $eamilMsg .= "<p style=\"font-size: 14px; line-height: 25px; text-align: left; margin: 0;\"><span style='font-size: 17px; mso-ansi-font-size: 18px;'><a href='{$v['url']}'>{$v['title']}</a></span></p>";
            }

            foreach($entNews['data'] as $v){
                $entNewMsg .= "{$v['title']}\r\n{$v['url']}\r\n\r\n";
            }
        }

        $JpKnowledgeRecoveryConfigModel = 'app\models\JpKnowledgeRecoveryConfig';

        $maildata = [
            'title'  => '每日摘要',
            'news'  => [
                [
                    'subtitle' => '热点新闻',
                    'data' => $news['data'],
                ],
                [
                    'subtitle' => '娱乐头条',
                    'data' => $entNews['data'],
                ],
                ],
        ];

        $wxRebotData = [
            'msgtype' => 'text',
            'text' => [
                'content'=> $newMsg,
//                'mentioned_list'=> ['高峰;'],//'@all'
//                'mentioned_mobile_list'=> ['15026852404'],//'@all'
            ]
        ];
        Common::httpPost('https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=b17603f1-7181-4c3e-8167-bd6dcbe9d146',$wxRebotData);

        $wxRebotData = [
            'msgtype' => 'text',
            'text' => [
                'content'=> $entNewMsg,
            ]
        ];
        Common::httpPost('https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=b17603f1-7181-4c3e-8167-bd6dcbe9d146',$wxRebotData);

        $config = $JpKnowledgeRecoveryConfigModel::find()->where(['userId'=>'super','isDelete'=>0])->asArray()->one();

        //发送邮件
        \Yii::$app->mailer->setTransport([
            'class' => 'Swift_SmtpTransport',
            'host' => $config['setSmtp'],
            'username' => $config['setEmail'],
            'password' => $config['setEmailPwd'],
            'port' => '465',       //阿里对25端口限制
            'encryption' => 'ssl',  //MAIL_ENCRYPTION加密方式由‘tsl’改成‘ssl’
        ]);

        \Yii::$app->mailer->compose('news',['data'=>$maildata]) // compose()渲染一个视图作为邮件内容
        ->setFrom([$config['setEmail']=>'WindBlog By WalkingSun'])
            ->setTo($config['sendEmail'])
            ->setSubject($maildata['title'])
//            ->setTextBody(11)
            ->send();
    }



    public function getNews( $url,$top_cat , $top_time, $top_show_num,$js_var= 'all_1_data01' ){
        //http://ent.sina.com.cn/hotnews/ent/Daily/
        $url = "{$url}/ws/GetTopDataList.php?top_type=day&top_cat={$top_cat}&top_time={$top_time}&top_show_num={$top_show_num}&top_order=DESC&js_var=$js_var";
        $client = new \GuzzleHttp\Client(['base_uri' => $url]);
        $response = $client->request('GET');
        if( $response->getStatusCode()=='200' ) {
            $contents = trim($response->getBody()->getContents(),"var {$js_var} =\n");
            $contents = substr($contents,0,-1);
            return json_decode( $contents,1);
        }
        return false;
    }

    /** 产品热点
     * @param null $nums 限制数量
     * @return array
     */
    protected function getProductNews( $nums=null ){
        $result = [];
        $url = 'http://www.woshipm.com/__api/v1/browser/popular?paged=1&num=100&action=laodpostphp';
        $data = Common::httpGet($url);
        if( $data ){
            $data = json_decode($data,1);
            $productNewFile = \Yii::$app->basePath . '/runtime/logs/product_news.log';
            if( !file_exists($productNewFile) ){
                file_put_contents($productNewFile,json_encode(['data'=>[]]));
            }
            $productNewExits = file_get_contents($productNewFile);
            $productNewExits = json_decode( $productNewExits,1);
            if($productNewExits['data']){
                $counts = count($productNewExits['data']);
                $outs = $counts-30;
                if( $outs>0 ){
                    while($outs--){
                        array_shift($productNewExits['data']);
                    }
                }
            }

            $posi=0;
            foreach ($data['payload'] as $k=>$v){

                if( in_array($v['id'],$productNewExits['data']) ) continue;

                if($nums && $posi>=$nums) break;

                $result[$k]['title'] = $v['title'];
                $result[$k]['url'] = $v['permalink'];
                $productNewExits['data'][] = $v['id'];

                $posi++;
            }

            file_put_contents($productNewFile,json_encode($productNewExits));
        }
        return $result;
    }

}