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
class JpUser extends Basic
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'JP_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'username', 'password', ], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'blogType' => 'Blog Type',
            'username' => 'Username',
            'password' => 'Password',
            'blogid' => 'Blogid',
        ];
    }
}
