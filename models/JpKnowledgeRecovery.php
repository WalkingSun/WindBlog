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
class JpKnowledgeRecovery extends Basic
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'JP_knowledgeRecovery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title',  ], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => 'title',
            'href' => 'href',
            'remark' => 'remark',
            'createtime' => 'createtime',
        ];
    }

    public function saveData( $data ){
        $DB = new DB();

        if( self::find()->where(['title'=>$data['title']])->asArray()->one()  ){
            return $DB->update(self::tableName(),$data,['title'=>$data['title']]);
        }else{
            return $DB->insert(self::tableName(),$data);
        }


    }
}
