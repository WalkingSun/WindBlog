<?php

namespace app\models;


/**
 * This is the model class for table "JP_blogRecord".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $fileurl
 * @property string $cnblogId
 * @property string $51ctoId
 * @property string $sinaId
 * @property string $csdnId
 * @property string $163Id
 * @property string $oschinaId
 * @property string $chinaunixId
 * @property string $createtime
 * @property integer $isDelete
 */
class JpBlogRecord extends Basic
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'JP_blogRecord';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'isDelete'], 'integer'],
            [['createtime'], 'safe'],
            [['title', 'fileurl','cnblogsType'], 'string', 'max' => 255],
            [['content'], 'string', 'max' => 8000],
            [['cnblogId', '51ctoId', 'sinaId', 'csdnId', '163Id', 'oschinaId', 'chinaunixId'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'fileurl' => 'Fileurl',
            'cnblogId' => 'Cnblog ID',
            '51ctoId' => '51cto ID',
            'sinaId' => 'Sina ID',
            'csdnId' => 'Csdn ID',
            '163Id' => '163 ID',
            'oschinaId' => 'Oschina ID',
            'chinaunixId' => 'Chinaunix ID',
            'createtime' => 'Createtime',
            'isDelete' => 'Is Delete',
            'cnblogsType' => 'cnblogsType',
        ];
    }
}
