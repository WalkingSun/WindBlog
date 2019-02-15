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
class JpKnowledgeRecoveryConfig extends Basic
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'JP_knowledgeRecoveryConfig';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['frequency',  ], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'frequency' => '频率',
        ];
    }
}
