<?php

namespace app\commands;

use app\models\Common;
use app\models\DB;
use app\models\JpBlogConfig;
use app\models\MetaWeblog;
use yii\console\Controller;

/**
 * 知识复盘定时发送论题
 * Class RecoveryController
 * @package app\commands
 */
class RecoveryController extends Controller
{
    public $limitTime=1;    //限制天数  day

    public function actionIndex(){
        $DB = new DB();
        $userModel = 'app\models\JpUser';
        $JpKnowledgeRecoveryConfigModel = 'app\models\JpKnowledgeRecoveryConfig';
        $model = 'app\models\JpKnowledgeRecovery';
        $JpKnowledgeRecoveryLog = 'app\models\JpKnowledgeRecoverySendLog';
        $users = $userModel::find()->select([])->where(['isDelete'=>0])->asArray()->all();
        array_push($users,['userId'=>'super','username'=>'super']);

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

                \Yii::$app->mailer->compose() // compose()渲染一个视图作为邮件内容
                ->setFrom($config[$v['userId']]['setEmail'])
                    ->setTo($config[$v['userId']]['sendEmail'])
                    ->setSubject($sendMsg['title'])
                    ->setTextBody($sendMsg['content'])
                    ->setHtmlBody("<a href='{$sendMsg['href']}'>{$sendMsg['title']}</a>")
                    ->send();

                $DB->insert($JpKnowledgeRecoveryLog::tableName(),['userId'=>$v['userId'],'krId'=>$sendMsg['id'],'createtime'=>date('Y-m-d H:i:s'),'remark'=>'发送论题']);

            }
        }catch (\Exception $e){
            var_dump($e->getMessage());
            Common::sendEmail($config['super']['setSmtp'],$config['super']['setEmail'],$config['super']['setEmailPwd'],'465','ssl',$config['super']['setEmail'],$config['super']['sendEmail'],'错误信息',$e->getMessage(),$e->getMessage());
        }

        die('success');
    }


    //cnblogs 同步博客记录到知识复盘
    public function actionBlogsync(){

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
        exit('success!');
    }
}
