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
                if( $config[$v['userId']]['tagList'] ) $data->orWhere(['in','tag',explode(',',$config[$v['userId']]['tagList'])]);
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
            Common::sendEmail($config['super']['setSmtp'],$config['super']['setEmail'],$config['super']['setEmailPwd'],'465','ssl',[$config['super']['setEmail']=>'WindBlog By WalkingSun'],$config['super']['sendEmail'],'错误信息',$e->getMessage(),$e->getMessage());
        }

        die('success');
    }


    //同步站点博客 到知识复盘
    public function actionBlogsync(){

        $syncWeb = ArticleFactory::$blogs;
        if( $syncWeb ){
            foreach ($syncWeb as $site){
                $model =  ArticleFactory::init($site);
                $model->pull();
            }
        }


        exit('success!');
    }

}
