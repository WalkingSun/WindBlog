<?php

namespace app\commands;

use app\models\Common;
use app\models\DB;
use app\models\JpBlogConfig;
use app\models\MetaWeblog;
use yii\console\Controller;

class RecoveryController extends Controller
{

    public function actionIndex(){
        $userModel = 'app\models\JpUser';
        $JpKnowledgeRecoveryConfigModel = 'app\models\JpKnowledgeRecoveryConfig';
        $model = 'app\models\JpKnowledgeRecovery';
        $JpKnowledgeRecoveryLog = 'app\models\JpKnowledgeRecoveryLog';
        $users = $userModel::find()->select([])->where(['isDelete'=>0])->asArray()->all();
        array_push($users,['userId'=>'super']);

        $config = $JpKnowledgeRecoveryConfigModel::find()->where(['isDelete'=>0])->asArray()->index('userId')->all();
        foreach ($users as $v){
            if( !( $config[$v['userId']]['frequency'] && $config[$v['userId']]['sendEmail'] && $config[$v['userId']]['setEmail'] && $config[$v['userId']]['setEmailPwd'] ) )  Common::addLog('error.log',$v['userName'].'邮箱设置不合法');

            $filter['userId'] = $v['userId'];
            $andWhere[] = [1=>1];
            if( $config[$v['userId']]['typeList'] ) $andWhere[]=['in','type',$config[$v['userId']]['typeList']];
            if( $config[$v['userId']]['tagList'] ) $andWhere[]=['in','tag',$config[$v['userId']]['tagList']];

            $data = $model::find()->select([])->where($filter)->andWhere($andWhere)->asArray()->index('id')->all();
            $logs = $JpKnowledgeRecoveryLog::find()->select('krId')->where(['userId'=>$v['userId']])->andWhere(['>=','createtime',date('Y-m-d H:i:s',strtotime('-1 month'))])->asArray()->index('krId')->all();

            if( $data ){
                foreach ( $data as $k=>$v){
                    if( isset($logs[$v['id']]) ) unset($data[$k]);
                }

                sort($data);
            }

            $randnum = rand(0,count($data)-1);
            $sendMsg = $data[$randnum];

            //消息模版

            //发送邮件


        }

        die('success');
    }

}
