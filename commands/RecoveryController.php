<?php

namespace app\commands;

use app\models\ArticleFactory;
use app\models\Common;
use app\models\DB;
use app\models\JpBlogConfig;
use app\models\MetaWeblog;
use PHPHtmlParser\Dom;
use yii\console\Controller;

/**
 * 知识复盘定时发送论题
 * Class RecoveryController
 * @package app\commands
 */
class RecoveryController extends Controller
{
    public $limitTime=30;    //限制天数  day

    public function actionIndex(){
        $DB = new DB();
        $userModel = 'app\models\JpUser';
        $JpKnowledgeRecoveryConfigModel = 'app\models\JpKnowledgeRecoveryConfig';
        $model = 'app\models\JpKnowledgeRecovery';
        $JpKnowledgeRecoveryLog = 'app\models\JpKnowledgeRecoverySendLog';
        $users = $userModel::find()->select([])->where(['isDelete'=>0])->asArray()->all();
        array_push($users,['userId'=>'super','username'=>'super']);

        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try{
            $config = $JpKnowledgeRecoveryConfigModel::find()->where(['isDelete'=>0])->asArray()->indexBy('userId')->all();
            foreach ($users as $v){
                if( !(isset($config[$v['userId']])  && $config[$v['userId']]['sendEmail'] && $config[$v['userId']]['setEmail'] && $config[$v['userId']]['setEmailPwd'] ) )
                {
                    Common::addLog('error.log',$v['username'].'邮箱设置不合法');
                    continue;
                }

                $filter = ['userId'=>$v['userId']];
                $data = $model::find()->select([])->where($filter);
                if( $config[$v['userId']]['typeList'] ) $data->andWhere(['in','type',explode(',',$config[$v['userId']]['typeList'])]);
                if( $config[$v['userId']]['tagList'] ) $data->andWhere(['in','tag',explode(',',$config[$v['userId']]['tagList'])]);
                $data =$data->asArray()->indexBy('id')->all();
                $logs = $JpKnowledgeRecoveryLog::find()->select('krId')->where(['userId'=>$v['userId']])->andWhere(['>=','createtime',date('Y-m-d H:i:s',strtotime("-{$this->limitTime} day"))])->asArray()->indexBy('krId')->all();

                if(  $data&&$logs ){
                    foreach ( $data as $k=>$v){
                        if( isset($logs[$v['id']]) ) unset($data[$k]);
                    }
                }
                if( !$data ) continue;
                sort($data);
                $randnum = rand(0,count($data)-1);
                $sendMsg = $data[$randnum];

                //发送邮件
                \Yii::$app->mailer->setTransport([
                    'class' => 'Swift_SmtpTransport',
                    'host' => $config[$v['userId']]['setSmtp'],
                    'username' => $config[$v['userId']]['setEmail'],
                    'password' => $config[$v['userId']]['setEmailPwd'],
                    'port' => '465',       //阿里对25端口限制
                    'encryption' => 'ssl',  //MAIL_ENCRYPTION加密方式由‘tsl’改成‘ssl’
                ]);

                // 推送模版
                \Yii::$app->mailer->compose('recovery',['data'=>$sendMsg]) // compose()渲染一个视图作为邮件内容
                ->setFrom($config[$v['userId']]['setEmail'])
                    ->setTo($config[$v['userId']]['sendEmail'])
                    ->setSubject($sendMsg['title'])
                    ->setTextBody($sendMsg['content'])
//                    ->setHtmlBody("<a href='{$sendMsg['href']}'>{$sendMsg['title']}</a>")
                    ->send();

                $DB->insert($JpKnowledgeRecoveryLog::tableName(),['userId'=>$v['userId'],'krId'=>$sendMsg['id'],'createtime'=>date('Y-m-d H:i:s'),'remark'=>'发送论题']);

            }
            $transaction->commit();
        }catch (\Exception $e){
            $transaction->rollBack();
            var_dump( $e->getLine(),$e->getMessage());
            Common::sendEmail($config['super']['setSmtp'],$config['super']['setEmail'],$config['super']['setEmailPwd'],'465','ssl',$config['super']['setEmail'],$config['super']['sendEmail'],'错误信息',$e->getMessage(),$e->getMessage());
        }

        die('success');
    }


    //cnblogs 同步博客记录到知识复盘
    public function actionBlogsync(){

        $syncWeb = ArticleFactory::$blogs;
        if( $syncWeb ){
            foreach ($syncWeb as $site){        $site = ['id'=>3];
                $model =  ArticleFactory::init($site);
                $model->pull();
            }
        }


        exit('success!');
    }

    //segmentfault 收藏同步知识复盘
    public function actionStarsSync(){

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
        var_dump('success');

    }

}
