<?php

namespace app\commands;

use app\models\Common;
use app\models\DB;
use app\models\JpBlogConfig;
use app\models\JpBlogRecord;
use app\models\JpUser;
use app\models\MetaWeblog;
use yii\console\Controller;

class MetaweblogController extends Controller
{
    public $modelClass= 'app\models\JpBlogQueue';
    protected $user;
    protected $userConfig;

    public function actionIndex(){
        $model = $this->modelClass;
        $modelBlogRecord = 'app\models\JpBlogRecord';
        $data = $model::find()->where(['publishStatus'=>0])->asArray()->all();

        $this->userConfig = \app\models\JpBlogConfig::find()->select([])->asArray()->indexBy('userId')->all();

        $DB = new DB();

        if( $data ){
            foreach ($data as $v){
                $blog = $modelBlogRecord::find()->where(['id'=>$v['blogId']])->asArray()->one();
                $blogConfig = $this->userConfig[$blog['userId']];

                $blogName = Common::blogParamName($v['blogType']);
                $blogid = $blogConfig['blogid']?:'';

                $connection = \Yii::$app->db;
                $transaction = $connection->beginTransaction();
                try{
                    $blogMetaweblogUrl = Common::MetaweblogUrl($v['blogType'],$blogid);
                    $target = new MetaWeblog( $blogMetaweblogUrl );
                    $target->setAuth( $blogConfig['username'],$blogConfig['password'] );

                    $DB->update($model::tableName(),['publishStatus'=>1],['queueId'=>$v['queueId']]);   //更新队列状态  进行中

                    #执行动作，1 创建，2 更新，3 删除
                    if( $v['action']==1 || $v['action']==2 ){
                        $v['action'] = $blog[$blogName.'Id'] ? 2:1;
                    }

                    switch ($v['action']){
                        case   1:
                            $this->save($blog['userId'],$target,$blog,$blogName,$v);
                            break;
                        case    2:
                            $this->save($blog['userId'],$target,$blog,$blogName,$v);
                            break;
                        case    3:
                            $this->delete($blog['userId'],$target,$blog);
                            break;
                        default:
                            continue;
                    }
                    $transaction->commit();
                }catch (\Exception $e){
                    Common::addLog('error.log',$e->getMessage());
                    $transaction->rollback();
                }
            }
        }

        die('success');
    }

    protected function save( $userId,$target,$blog ,$blogName='',$queue){
        $model = 'app\models\JpBlogQueue';
        $model_new = new $model;
        return $model_new->sync( $userId, $target,$blog ,$blogName,$queue );
    }

    protected function delete( $userId,$target,$blog ){

    }
}
