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
}
