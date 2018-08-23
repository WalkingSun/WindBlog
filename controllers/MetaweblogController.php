<?php
/**
 * Created by PhpStorm.
 * User: MW
 * Date: 2018/6/7
 * Time: 9:51
 */

namespace app\controllers;


use app\models\Common;
use app\models\DB;
use app\models\JpBlogConfig;
use app\models\MetaWeblog;
use yii\web\Controller;

class MetaweblogController extends Controller
{
    public $modelClass= 'app\models\JpBlogRecord';
    public $data;
    public $result;
    public $enableCsrfValidation = false;

    public function init()
    {
        parent::init();
        $this->data = array_merge(\Yii::$app->request->get(),\Yii::$app->request->post());
    }

    public function actionIndex(){
        $d = $this->data;
        $model =$this->modelClass;

        $filter = ['isDelete'=>0];
        $offset = !empty($d['page']) ? $d['page']:1;
        $orderType = ['createtime'=>SORT_DESC];
        $count = $model::find()->select('id')->where(['isDelete'=>0])->count();
        $pagination = new \yii\data\Pagination([ 'defaultPageSize' => 5, 'totalCount'=>$count,]);//print_r($pagination->limit);die;
        $this->result = $model::getList($cols = array(), $filter , $offset , $limit=$pagination->limit , $andWhere='', $orWhere='', $orderType ,$andWhereArray = []);
        $blogConfig = JpBlogConfig::find()->where(['blogType'=>6])->asArray()->one();
        return $this->render('index',['result'=>$this->result,'pagination'=>$pagination,'blogConfig'=>$blogConfig]);
    }

    public function actionQueue(){
        $d = $this->data;
        $model = 'app\models\JpBlogQueue';

        $DB = new DB();
        $data = [
            'blogId'    => $d['blogId'],
            'action'    => $d['action'],
            'publishStatus'    => '0',
            'response'    => '',
            'createtime'    => date('Y-m-d'),
            'updatetime'    => date('Y-m-d'),
            'blogType'=> 6
        ];
        $DB->insert($model::tableName(),$data);

        echo json_encode(['code'=>200,'msg'=>'添加成功']);
    }

    public function actionAdd(){

        //查询分类
        $blogConfig = JpBlogConfig::find()->where(['blogType'=>6])->asArray()->one();       //获取博客园配置
        $MetaWeblog = new MetaWeblog();
        $Categories = $MetaWeblog->get( $blogConfig['blogType'],$blogConfig['username'] , $blogConfig['password'] ,$blogConfig['blogid'], $isCache = 1 );
        $model = $this->modelClass;
        $d = $this->data;

        if( !empty($d['edit']) ){
            $insertData['title'] = !empty($d['title']) ? $d['title']:Common::echoJson(403,'请输入标题');
            $insertData['content'] = !empty($d['content']) ? $d['content']:'';
            $insertData['fileurl'] = !empty($d['fileurl']) ? $d['fileurl']:'';
            if(  !$insertData['content'] && !$insertData['fileurl']  ) Common::echoJson(403,'请输入博客内容');

            $insertData['cnblogsId'] = '';
            $insertData['51ctoId'] = '';
            $insertData['sinaId'] = '';
            $insertData['csdnId'] = '';
            $insertData['163Id'] = '';
            $insertData['oschinaId'] = '';
            $insertData['chinaunixId'] = '';
            $insertData['createtime'] = date('Y-m-d');
            $insertData['cnblogsType'] = !empty($d['cnblogsType']) ? implode(",",$d['cnblogsType']):'';
            $DB = new DB();
            $DB->insert($model::tableName(),$insertData);
            Common::echoJson('200','添加成功');
        }

        return $this->render('add',['Categories'=>$Categories[0]]);
    }

    public function actionEdit(){
        $d = $this->data;
        if( empty($d['blogId']) ) Common::echoJson(403,'参数错误');

        //查询分类
        $blogConfig = JpBlogConfig::find()->where(['blogType'=>6])->asArray()->one();       //获取博客园配置
        $MetaWeblog = new MetaWeblog();
        $Categories = $MetaWeblog->get( $blogConfig['blogType'],$blogConfig['username'] , $blogConfig['password'] ,$blogConfig['blogid'], $isCache = 1 );

        $model = $this->modelClass;
        $record = $model::find()->where(['id'=> $d['blogId']])->asArray()->one();
        if( !empty($d['edit']) ){
            $filter = ['id'=>$record['id']];
            $upData['title'] = !empty($d['title']) ? $d['title']:Common::echoJson(403,'请输入标题');
            $upData['content'] = !empty($d['content']) ? $d['content']:'';
            $upData['fileurl'] = !empty($d['fileurl']) ? $d['fileurl']:'';
            if(  !$upData['content'] && !$upData['fileurl']  ) Common::echoJson(403,'请输入博客内容');
            $upData['cnblogsType'] = !empty($d['cnblogsType']) ? implode(",",$d['cnblogsType']):'';
            $DB = new DB();
            $DB->update($model::tableName(),$upData,$filter);
            Common::echoJson('200','添加成功');
        }

        return $this->render('edit',['Categories'=>$Categories[0],'record'=>$record]);
    }

    public function actionDel(){
        $d = $this->data;
        $model = $this->modelClass;

        $id = !empty($d['blogId'])?$d['blogId']:Common::echoJson(403,'id缺失');

        $blog = $model::find()->where(['id'=>$id])->asArray()->one() or Common::echoJson(404,'记录不存在或已删除');

        $DB = new DB();
        $DB->update($model::tableName(),['isDelete'=>1],['id'=>$id]);
        Common::echoJson(200,'操作成功');
    }

    //查看队列
    public function actionCheckqueue(){
        $this->layout = false;
        $d = $this->data;
        $model = 'app\models\JpBlogQueue';

        $result = [];
        if( $d['blogid'] ){

            $result = $model::find()->where(['blogId'=>$d['blogid']])->asArray()->all();

        }

        return $this->render('checkqueue',['result'=>$result]);
    }

    //更新队列
    public function actionUpdatequeue(){
        $this->layout = false;
        $d = $this->data;
        $model = 'app\models\JpBlogQueue';
        if( !$d['queueid'] ){
            Common::echoJson(403,'参数缺失');
        }

        $DB = new DB();
        $DB->update($model::tableName(),['publishStatus'=>0],['queueId'=>$d['queueid']]);
        Common::echoJson(200,'添加成功！');
    }


    /**
     * 初始化设置
     */
    public function actionInit(){
        $d = $this->data;
        if( !empty($d['blogType']) ){
            //检测是否正确
            //查询分类
            $MetaWeblog = new MetaWeblog();
            $blogName = Common::blogParamName($d['blogType']);
            $Categories = $MetaWeblog->get( $d['blogType'],$d['username'] , $d['password'] ,$d['blogid'], $isCache = 0 );
            if( !is_array($Categories) ) Common::echoJson(400,'设置参数有误，请仔细核对下');

            $DB = new DB();
            if( !JpBlogConfig::find()->where(['blogType'=>$d['blogType']])->asArray()->one() ){
                $DB->insert(JpBlogConfig::tableName(),['blogType'=>$d['blogType'],'username'=>$d['username'],'password'=>$d['password'],'blogid'=>$d['blogid'],'isEnable'=>$d['isEnable']]);
            }else{
                $DB->update(JpBlogConfig::tableName(),['username'=>$d['username'],'password'=>$d['password'],'blogid'=>$d['blogid'],'isEnable'=>$d['isEnable']],['blogType'=>$d['blogType']]);
            }
//            Common::echoJson(200,'设置成功');
        }
        $blogConfig = JpBlogConfig::find()->asArray()->all();

        return $this->render('init',['blogConfig'=>$blogConfig]);
    }

    //同步博客
    public function actionSync(){

    }
}