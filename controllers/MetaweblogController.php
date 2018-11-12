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
        $pagination = new \yii\data\Pagination([ 'defaultPageSize' => 10, 'totalCount'=>$count,]);//print_r($pagination->limit);die;
        $this->result = $model::getList($cols = array(), $filter , $offset , $limit=$pagination->limit , $andWhere='', $orWhere='', $orderType ,$andWhereArray = []);

        //查询配置
        $configs = JpBlogConfig::find()->where(['isEnable'=>1])->asArray()->all();

        return $this->render('index',['result'=>$this->result,'pagination'=>$pagination,'blogConfig'=>$configs]);
    }

    public function actionQueue(){
        $d = $this->data;
        $model = 'app\models\JpBlogQueue';

        //查询配置
        $configs = JpBlogConfig::find()->where(['isEnable'=>1])->asArray()->all() or Common::echoJson(400,'请自动化配置');

        $DB = new DB();
        $data = [];
        foreach ($configs as $v){
            $data[] = [
                'blogId'    => $d['blogId'],
                'action'    => $d['action'],
                'publishStatus'    => '0',
                'response'    => '',
                'createtime'    => date('Y-m-d'),
                'updatetime'    => date('Y-m-d'),
                'blogType'=> $v['blogType']
            ];
        }

        $DB->batchInsert($model::tableName(),$data);

        echo json_encode(['code'=>200,'msg'=>'添加成功']);
    }

    public function actionAdd(){

        //查询配置
        $configs = JpBlogConfig::find()->where(['isEnable'=>1])->asArray()->all() or Common::echoJson(400,'请自动化配置');
        $MetaWeblog = new MetaWeblog();

       foreach ($configs as $v){
           //查询分类
           $Categories[$v['blogType']] = $MetaWeblog->get( $v['blogType'],$v['username'] , $v['password'] ,$v['blogid'], $isCache = 1 );
       }

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

            //添加分类
            if( $blogCates = $d['cnblogsType'] ){
                foreach ($blogCates as $k=>$v){
                    $blogName = Common::blogParamName($k);
                    $insertData[$blogName.'Type'] = !empty($v) ? implode(",",$v):'';
                }
            }

            $DB = new DB();
            $DB->insert($model::tableName(),$insertData);
            Common::echoJson('200','添加成功');
        }

        return $this->render('add',['Categories'=>$Categories]);
    }

    public function actionEdit(){
        $d = $this->data;
        if( empty($d['blogId']) ) Common::echoJson(403,'参数错误');

        //查询配置
        $configs = JpBlogConfig::find()->where(['isEnable'=>1])->asArray()->all() or Common::echoJson(400,'请自动化配置');
        $MetaWeblog = new MetaWeblog();

        foreach ($configs as $v){
            //查询分类
            $Categories[$v['blogType']] = $MetaWeblog->get( $v['blogType'],$v['username'] , $v['password'] ,$v['blogid'], $isCache = 1 );
        }

        $model = $this->modelClass;
        $record = $model::find()->where(['id'=> $d['blogId']])->asArray()->one();
        if( !empty($d['edit']) ){
            $filter = ['id'=>$record['id']];
            $upData['title'] = !empty($d['title']) ? $d['title']:Common::echoJson(403,'请输入标题');
            $upData['content'] = !empty($d['content']) ? $d['content']:'';
            $upData['fileurl'] = !empty($d['fileurl']) ? $d['fileurl']:'';
            if(  !$upData['content'] && !$upData['fileurl']  ) Common::echoJson(403,'请输入博客内容');
            //添加分类
            if( $blogCates = $d['cnblogsType'] ){
                foreach ($blogCates as $k=>$v){
                    $blogName = Common::blogParamName($k);
                    $upData[$blogName.'Type'] = !empty($v) ? implode(",",$v):'';
                }
            }
            $DB = new DB();
            $DB->update($model::tableName(),$upData,$filter);
            Common::echoJson('200','添加成功');
        }

        return $this->render('edit',['Categories'=>$Categories,'record'=>$record]);
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
        $this->layout = false;
        $d = $this->data;
        $model = 'app\models\JpBlogQueue';
        $modelBlogRecord = 'app\models\JpBlogRecord';
        $DB = new DB();

        if( !$d['queueid'] )   Common::echoJson(403,'参数缺失');

        $queue = $model::find()->where(['queueId'=>$d['queueid']])->asArray()->one();
        if( $queue['publishStatus']==2 ) Common::echoJson(400,'博客已发布');
        $blogConfig = JpBlogConfig::find()->where(['blogType'=>$queue['blogType']])->asArray()->one();
        $blogName = Common::blogParamName($queue['blogType']);
        $blogid = $blogConfig['blogid']?:'';

        try{
            $blogMetaweblogUrl = Common::MetaweblogUrl($queue['blogType'],$blogid);
            $target = new MetaWeblog( $blogMetaweblogUrl );
            $target->setAuth( $blogConfig['username'],$blogConfig['password'] );
            $blog = $modelBlogRecord::find()->where(['id'=>$queue['blogId']])->asArray()->one();
            $DB->update($model::tableName(),['publishStatus'=>1],['queueId'=>$queue['queueId']]);   //更新队列状态  进行中

            #执行动作，1 创建，2 更新，3 删除
            if( $queue['action']==1 || $queue['action']==2 ){
                $queue['action'] = $blog[$blogName.'Id'] ? 2:1;
            }

            switch ($queue['action']){
                case   1:
                    $this->save($target,$blog,$blogName,$queue);
                    break;
                case    2:
                    $this->save($target,$blog,$blogName,$queue);
                    break;
                case    3:
                    $this->delete($target);
                    break;
                default:
                    continue;
            }

        }catch (\Exception $e){
            Common::echoJson($e->getCode(),$e->getMessage());
            Common::addLog('error.log',$e->getMessage());
        }

        Common::echoJson(200,'发布成功');
    }

    protected function save( MetaWeblog $target,$blog ,$blogName='',$queue){
        $model = 'app\models\JpBlogQueue';
        $modelBlogRecord = 'app\models\JpBlogRecord';
        $DB = new DB();

        $blogIteam = $blogName?$blog[$blogName.'Id']:'';
        $content = $blog['content']?:file_get_contents($blog['fileurl']);
        $content = preg_replace('/\---.*?---/si', '', $content,1);    //过滤 --- jekyll描述信息 的内容
//        Common::addLog('error.log',$content);die;
        //xml替换不允许字符 参考： http://note.youdao.com/noteshare?id=f303e349322890f31aaea3bc84345d88&sub=wcp1529043319262675
        $content = str_replace('&','&amp;',$content);
        $content = str_replace('"','&quot;',$content);
        $content = str_replace("'",'&apos;',$content);
        $content = str_replace(">",'&gt;',$content);
        $content = str_replace("<",'&lt;',$content);
        $categories = $blog['cnblogsType']? explode(',',$blog['cnblogsType']) : [ '[Markdown]' ];
        $params = [
            'title'=> $blog['title'],
            'description'=> $content,
            'categories'=> $categories            //编辑器格式+分类
        ];
        if( !$blogIteam ){
            if( $target->newPost( $params ) ){
                $blog_id = $target->getBlogId();
                $DB->update($modelBlogRecord::tableName(),[$blogName.'Id'=>$blog_id],['id'=>$blog['id']]);
                $DB->update($model::tableName(),['publishStatus'=>2,'response'=>'success'],['queueId'=>$queue['queueId']]);                   //更新队列状态  发布成功
            }else{
                $DB->update($model::tableName(),['publishStatus'=>3,'response'=>$target->getErrorMessage()],['queueId'=>$queue['queueId']]);                   //更新队列状态  发布失败
                throw new \Exception($target->getErrorMessage(),501);
            }
        }else{
            if( !$target->editPost( $blogIteam,$params ) ){
                $DB->update($model::tableName(),['publishStatus'=>3,'response'=>$target->getErrorMessage()],['queueId'=>$queue['queueId']]);                   //更新队列状态  发布失败
                throw new \Exception($target->getErrorMessage(),501);
            }else{
                $DB->update($modelBlogRecord::tableName(),[$blogName.'Id'=>$blogIteam],['id'=>$blog['id']]);
                $DB->update($model::tableName(),['publishStatus'=>2,'response'=>'success'],['queueId'=>$queue['queueId']]);                   //更新队列状态  发布成功
            }
        }
        return ;
    }

}