<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "JP_blogConfig".
 *
 * @property integer $blogType
 * @property string $username
 * @property string $password
 * @property string $blogid
 */
class JpKnowledgeRecoverySendLog extends Basic
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'JP_knowledgeRecoverySendLog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['krId',  ], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'krId' => '频率',
        ];
    }
}
