<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2019/2/13
 * Time: 10:56
 */

namespace app\controllers;


use app\models\Common;
use app\models\DB;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class RecoveryController extends BaseController
{
    public $modelClass= 'app\models\JpKnowledgeRecovery';
    public $data;
    public $result;
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','add','edit','del','set',],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex(){
        $d = $this->data;
        $model =$this->modelClass;

        $filter = ['userId'=>$this->userId ,'isDelete'=>0];
        $andWhereArray = [];
        if( !empty($d['title']) ){
            $andWhereArray[] = ['like','title',$d['title']];
        }

        $filter['tag'] = $d['tag']??'';
        $filter['type'] = $d['type']??'';
        $filter = array_filter($filter,function ($r){return $r!=null;});

        $offset = !empty($d['page']) ? $d['page']:1;
        $orderType = ['createtime'=>SORT_DESC];
        $count = $model::find()->select('id')->where(['userId'=>$this->userId ,'isDelete'=>0])->count();
        $pagination = new \yii\data\Pagination([ 'defaultPageSize' => 10, 'totalCount'=>$count,]);
        $this->result = $model::getList($cols = array(), $filter , $offset , $limit=$pagination->limit , $andWhere='', $orWhere='', $orderType=['id'=>SORT_DESC] ,$andWhereArray);

        return $this->render('index',['result'=>$this->result,'pagination'=>$pagination,]);
    }

    public function actionAdd(){
        $d = $this->data;

       $this->addData($d);

        return $this->render('edit');
    }

    public function actionEdit(){
        $d = $this->data;
        $model = $this->modelClass;

        if( !empty($d['id']) ) $rData = $model::find()->select([])->where(['id'=>$d['id'],'isDelete'=>0])->asArray()->one() or Common::echoJson(400,'资源未找到');

        $this->addData($d,$rData);

        return $this->render('edit',['data'=>$rData]);
    }

    public function actionDel(){
        $d = $this->data;
        $model = $this->modelClass;

        $id = !empty($d['id'])?$d['id']:Common::echoJson(403,'id缺失');

        $blog = $model::find()->where(['id'=>$id])->asArray()->one() or Common::echoJson(404,'记录不存在或已删除');

        $DB = new DB();
        $DB->update($model::tableName(),['isDelete'=>1],['id'=>$id]);
        Common::echoJson(200,'操作成功');
    }

    public function actionConfig(){
        $d = $this->data;
        $model = 'app\models\JpKnowledgeRecoveryConfig';

        $config = $model::find()->select([])->where(['userId'=>$this->userId,'isDelete'=>0])->asArray()->one();
        if( !empty($d['edit']) ){

            $upData['userId'] = $this->userId;
            $upData['frequency'] = !empty($d['frequency'])?$d['frequency']:'';
            $upData['typeList'] = !empty($d['typeList'])?implode(',',$d['typeList']):'';
            $upData['tagList'] = !empty($d['tagList'])?implode(',',$d['tagList']):'';
            $upData['sendEmail'] = $d['sendEmail'];
            $upData['setEmail'] = $d['setEmail'];
            $upData['setEmailPwd'] = $d['setEmailPwd'];
            $upData['setPop3'] = $d['setPop3'];
            $upData['setSmtp'] = $d['setSmtp'];
            $upData['isEnable'] = $d['isEnable'];

            $DB= new DB();
            if( $config ){
                $DB->update($model::tableName(),$upData,['userId'=>$this->userId]);
            }else{
                $upData['createtime'] = date('Y-m-d H:i:s');
                $DB->insert($model::tableName(),$upData);
            }
            Common::echoJson(200,'success');
        }

        //查询标签
        $model = $this->modelClass;
        $tagAndTypeList = $model::find()->select(['tag','type'])->where(['userId'=>$this->userId])->asArray()->all();

        return $this->render('config',['data'=>$config,'tags'=>$tagAndTypeList]);
    }

    protected function addData( $d,$rData=[] ){
        $model = $this->modelClass;
        if( !empty($d['edit']) ){
            $insertData['title'] = !empty($d['title']) ? $d['title']:Common::echoJson(403,'请输入标题');
            $insertData['content'] = !empty($d['content']) ? $d['content']:'';
            $insertData['href'] = !empty($d['href']) ? $d['href']:'';
            $insertData['tag'] = !empty($d['tag']) ? $d['tag']:'';
            $insertData['type'] = !empty($d['type']) ? $d['type']:'';
            $insertData['frequency'] = !empty($d['frequency']) ? $d['frequency']:'';
            $insertData['remark'] = !empty($d['remark']) ? $d['remark']:'';
            $insertData['href'] = !empty($d['href']) ? $d['href']:'';
            $insertData['createtime'] =  empty($d['id']) ?date('Y-m-d'):$rData['createtime'];
            if( !empty($d['id']) )  $insertData['updatetime'] = ($rData['updatetime']) ?:date('Y-m-d');
            $insertData['userId'] = $this->userId ;

            $DB = new DB();
            if( !empty($d['id']) ) $DB->update($model::tableName(),$insertData,['id'=>$d['id']]);
            else  $DB->insert($model::tableName(),$insertData);

            Common::echoJson('200','提交成功');
        }

    }
}