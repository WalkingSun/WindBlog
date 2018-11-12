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
class JpBlogConfig extends Basic
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'JP_blogConfig';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blogType', 'username', 'password', 'blogid'], 'required'],
            [['blogType'], 'integer'],
            [['username', 'password', 'blogid'], 'string', 'max' => 64],
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
