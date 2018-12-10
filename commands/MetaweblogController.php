<?php

namespace app\commands;

use app\models\Common;
use app\models\DB;
use app\models\JpBlogConfig;
use app\models\MetaWeblog;
use yii\console\Controller;

class MetaweblogController extends Controller
{
    public $modelClass= 'app\models\JpBlogQueue';
    protected $user;

    public function actionIndex(){
        $model = $this->modelClass;
        $modelBlogRecord = 'app\models\JpBlogRecord';
        $data = $model::find()->where(['publishStatus'=>0])->asArray()->all();

        $this->user = \app\models\JpBlogConfig::find()->select(['blogType','blogid','isTOC','isEnable'])->asArray()->indexBy('blogType')->all();

        $DB = new DB();

        if( $data ){
            foreach ($data as $v){
                $blogConfig = JpBlogConfig::find()->where(['blogType'=>$v['blogType']])->asArray()->one();

                $blogName = Common::blogParamName($v['blogType']);
                $blogid = $blogConfig['blogid']?:'';

                $connection = \Yii::$app->db;
                $transaction = $connection->beginTransaction();
                try{
                    $blogMetaweblogUrl = Common::MetaweblogUrl($v['blogType'],$blogid);
                    $target = new MetaWeblog( $blogMetaweblogUrl );
                    $target->setAuth( $blogConfig['username'],$blogConfig['password'] );


                    $blog = $modelBlogRecord::find()->where(['id'=>$v['blogId']])->asArray()->one();
                    $DB->update($model::tableName(),['publishStatus'=>1],['queueId'=>$v['queueId']]);   //更新队列状态  进行中

                    #执行动作，1 创建，2 更新，3 删除
                    if( $v['action']==1 || $v['action']==2 ){
                        $v['action'] = $blog[$blogName.'Id'] ? 2:1;
                    }

                    switch ($v['action']){
                        case   1:
                            $this->save($target,$blog,$blogName,$v);
                            break;
                        case    2:
                            $this->save($target,$blog,$blogName,$v);
                            break;
                        case    3:
                            $this->delete($target);
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

    protected function save( $target,$blog ,$blogName='',$v){
        $model = 'app\models\JpBlogQueue';
        $modelBlogRecord = 'app\models\JpBlogRecord';
        $DB = new DB();

        $blogIteam = $blogName?$blog[$blogName.'Id']:'';
        $content = $blog['content']?:file_get_contents($blog['fileurl']);

        $preg = "/---(.|\s?)*---(\s)/";
        preg_match($preg,mb_substr($content,0,500,"UTF-8"),$match);
        if( !empty($match[0]) ){
            $n = strlen($match[0])-1;
            $content = substr($content,$n);
        }

        //xml替换不允许字符 参考： http://note.youdao.com/noteshare?id=f303e349322890f31aaea3bc84345d88&sub=wcp1529043319262675
        $content = str_replace('&','&amp;',$content);
        $content = str_replace('"','&quot;',$content);
        $content = str_replace("'",'&apos;',$content);
        $content = str_replace(">",'&gt;',$content);
        $content = str_replace("<",'&lt;',$content);

        //添加TOC
        if( $this->user[$v['blogType']]['isTOC']  )  $content =  '[TOC] '.$content;

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
                $DB->update($model::tableName(),['publishStatus'=>2,'response'=>'success'],['queueId'=>$v['queueId']]);                   //更新队列状态  发布成功
            }else{
                $DB->update($model::tableName(),['publishStatus'=>3,'response'=>$target->getErrorMessage()],['queueId'=>$v['queueId']]);                   //更新队列状态  发布失败
//                Common::addLog('error.log',$target->getErrorMessage());
                throw new \Exception($target->getErrorMessage());
            }
        }else{
            if( !$target->editPost( $blogIteam,$params ) ){
                $DB->update($model::tableName(),['publishStatus'=>3,'response'=>$target->getErrorMessage()],['queueId'=>$v['queueId']]);                   //更新队列状态  发布失败
                throw new \Exception($target->getErrorMessage());
            }else{
                $DB->update($modelBlogRecord::tableName(),[$blogName.'Id'=>$blogIteam],['id'=>$blog['id']]);
                $DB->update($model::tableName(),['publishStatus'=>2,'response'=>'success'],['queueId'=>$v['queueId']]);                   //更新队列状态  发布成功
            }
        }

    }

    protected function delete(){

    }
}
