<?php

namespace app\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "JP_gitWindblogSync".
 *
 * @property integer $id
 * @property string $git_filename
 * @property string $blog_title
 * @property integer $blogRecord_id
 * @property integer $is_deal
 * @property string $createtime
 * @property string $remark
 * @property integer $isDelete
 */
class JPGitWindblogSync extends Basic
{
    public static $instance;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'JP_gitWindblogSync';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['git_filename', 'blog_title'], 'required'],
            [['blogRecord_id', 'is_deal', 'isDelete'], 'integer'],
            [['createtime'], 'safe'],
            [['git_filename', 'blog_title'], 'string', 'max' => 64],
            [['remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'git_filename' => 'Git Filename',
            'blog_title' => 'Blog Title',
            'blogRecord_id' => 'Blog Record ID',
            'is_deal' => 'Is Deal',
            'createtime' => 'Createtime',
            'remark' => 'Remark',
            'isDelete' => 'Is Delete',
        ];
    }

    public static function getInstance(){
        if(  self::$instance == null ){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * github文件同步服务
     */
    public function addGitServer(  $fileData,$tags ){
        if( empty($tags['title']) ){
            Common::addLog('error.log',"{$fileData['url']} 未设置tile");
            return false;
        }

        $DB = new DB();
        $connection = \Yii::$app->db;

        //记录博客分类信息
        $blogTypes = Common::blogParamName();
        $blogTypesFlip = array_flip($blogTypes);
        $blogClassInfo = [];

        $blogTypeSeted = JpBlogConfig::find()->select(['blogType'])->where(['isEnable'=>1])->asArray()->all();
        $blogTypeSeted = array_column($blogTypeSeted,'blogType');
        foreach ($blogTypes as $v){
            //剔除未配置账户的博客类型
            if( !in_array( $blogTypesFlip[$v],$blogTypeSeted ) ) continue;

            if( isset($tags[$v.'Class']) ){
                $blogClassInfo[$v] = $this->classFormatDeal($tags[$v.'Class']);
            }
        }
        if( !$blogClassInfo ) return false;

        $datetime = date('Y-m-d H:i:s');
        $transaction = $connection->beginTransaction();
        try{
            //更新最新的博客
           $syncData = [
                'git_filename' => $fileData['markfile'],
                'blog_title' => $tags['title'],
                'blogRecord_id' => '',
                'is_deal' => '0',
                'createtime' => $fileData['fileTime'],
                'remark' => '',
                'isDelete' => '0',
           ];
            if( !self::find()->select([])->where(['git_filename'=>$syncData['git_filename'],'createtime'=>$syncData['createtime'],'isDelete'=>0])->asArray()->one() ){
                if( $blogRecord =JpBlogRecord::find()->select([])->where(['userId'=>'super','title'=>$tags['title'],'isDelete'=>0])->asArray()->one() ){
                    $syncData['blogRecord_id'] = $blogRecord['id'];
                }else{
                    $blogRecordData = [
                        'title'  => $tags['title'],
                        'content'  => '',
                        'fileurl'  => $fileData['url'],
                        'cnblogsId'  => '',
                        '51ctoId'  => '',
                        'sinaId'  => '',
                        'csdnId'  => '',
                        '163Id'  => '',
                        'oschinaId'  => '',
                        'chinaunixId'  => '',
                        'cnblogsType'  => '',
                        '51ctoType'  => '',
                        'sinaType'  => '',
                        'csdnType'  => '',
                        '163Type'  => '',
                        'oschinaType'  => '',
                        'chinaunixType'  => '',
                        'createtime'  => $datetime,
                        'isDelete'  => '0',
                        'userId' => 'super'
                    ];
                    $DB->insert('JP_blogRecord',$blogRecordData);
                    $syncData['blogRecord_id'] = $DB->insertid();
                }

                $DB->insert(self::tableName(),$syncData);

                foreach ($blogClassInfo as $k=>$v){
                    $blogRecordDataUp[$k.'Type'] = $v;

                    //插入队列
                    $queueData = [
                        'blogId'   =>  $syncData['blogRecord_id'],
                        'action'   =>  1,
                        'publishStatus'   =>  0,
                        'response'   =>  '',
                        'createtime'   =>  $datetime,
                        'updatetime'   =>  $datetime,
                        'blogType'   =>  $blogTypesFlip[$k],
                    ];
                    $DB->insert('JP_blogQueue',$queueData);
                }
               $DB->update('JP_blogRecord',$blogRecordDataUp,['id'=>$syncData['blogRecord_id']]);
            }
            else{
                Common::addLog('error.log',"{$fileData['url']} 已同步");
//                throw new Exception("{$fileData['url']} 已同步");
            }

            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollback();
            Common::addLog('error.log',$e->getMessage());
        }

    }

    //博客分类格式处理
    protected function classFormatDeal( $data ){
        str_replace("\\","",$data);
        return str_replace("\\","",$data);
    }
}
