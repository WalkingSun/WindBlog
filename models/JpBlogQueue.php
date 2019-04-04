<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "JP_blogQueue".
 *
 * @property integer $queueId
 * @property integer $blogId
 * @property integer $action
 * @property integer $publishStatus
 * @property string $response
 * @property string $createtime
 * @property string $updatetime
 */
class JpBlogQueue extends Basic
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'JP_blogQueue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['queueId', 'blogId'], 'required'],
            [['queueId', 'blogId', 'action', 'publishStatus'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['response'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'queueId' => 'Queue ID',
            'blogId' => 'Blog ID',
            'action' => 'Action',
            'publishStatus' => 'Publish Status',
            'response' => 'Response',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }

    /**
     * @param $user
     * @param MetaWeblog $target
     * @param $blog
     * @param string $blogName
     * @param $queue
     * @return bool
     * @throws \Exception
     */
    public function sync(  $userId,MetaWeblog $target,$blog ,$blogName='',$queue ){
        $model = 'app\models\JpBlogQueue';
        $modelBlogRecord = 'app\models\JpBlogRecord';
        $DB = new DB();

        $blogIteam = $blogName?$blog[$blogName.'Id']:'';
        $content = $blog['content']?:file_get_contents($blog['fileurl']);
        if( $content==false ) throw new \Exception("{$blog['fileurl']} 404 not found");
        $content = preg_replace('/\---.*?---/si', '', $content,1);    //过滤 --- jekyll描述信息 的内容

        //xml替换不允许字符 参考： http://note.youdao.com/noteshare?id=f303e349322890f31aaea3bc84345d88&sub=wcp1529043319262675
        $content = str_replace('&','&amp;',$content);
        $content = str_replace('"','&quot;',$content);
        $content = str_replace("'",'&apos;',$content);
        $content = str_replace(">",'&gt;',$content);
        $content = str_replace("<",'&lt;',$content);

        //添加TOC
        $userConfig = \app\models\JpBlogConfig::find()->select(['blogType','blogid','isTOC','isEnable'])->where(['userId'=>$userId])->asArray()->indexBy('blogType')->all();

        $categories = $blog['cnblogsType']? explode(',',$blog['cnblogsType']) : [ '[Markdown]' ];
        if( !empty($userConfig[$queue['blogType']]['isTOC'])  )  $content =  '[TOC] '.$content;
        $params = [
            'title'=> $blog['title'],
            'description'=> $content,
            'categories'=> $categories            //编辑器格式+分类
        ];
        if( !$blogIteam ){
            if( $target->newPost( $params ) ){
                $blog_id = $target->getBlogId();
                $DB->update($modelBlogRecord::tableName(),[$blogName.'Id'=>$blog_id],['id'=>$blog['id']]);

                $DB->update($model::tableName(),['publishStatus'=>2,'response'=>'success'],['queueId'=>$queue['queueId']]);                   //更新队列状态  发布失败

                //如果是super用户且类型为博客园，更新到知识复盘
                if( $userId=='super' && $blogName=='cnblogs'){
                    $kReconery =  new \app\models\JpKnowledgeRecovery;
                    $krData = ['userId'=>'super','title'=>$blog['title'],'content'=>'','href'=>"https://www.cnblogs.com/followyou/p/{$blog_id}.html",'tag'=>'','type'=>$blog['cnblogsType'],'remark'=>'cnblogs','createtime'=>date('Y-m-d H:i:s')];
                    $kReconery->saveData($krData);
                }

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
        return true;
    }
}
