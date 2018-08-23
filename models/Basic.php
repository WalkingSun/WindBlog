<?php
namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


class Basic extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        return [
            [
                'class'              => TimestampBehavior::className(),
                'createdAtAttribute' => 'createtime',
                'updatedAtAttribute' => 'updatetime',
                'value'              => date('Y-m-d H:i:s'),
            ]
        ];
    }

    function  rule(){
        return [];
    }

    public static function getList($cols = array(), $filter = array(), $offset = 0, $limit = -1, $andWhere, $orWhere, $orderType = null,$andWhereArray = [])
    {
        $model = static::find()->select($cols)->where($filter)->andWhere($andWhere)->orWhere($orWhere);
        if( $andWhereArray ){
            foreach ($andWhereArray as $v){
                $model->andWhere($v);
            }
        }

        if($offset>0){
            $model->offset(($offset-1)*$limit)->limit($limit);
        }
        return $model->orderBy($orderType)->asArray()->all();
    }

    function count($filter = array(), $andWhere, $orWhere,$andWhereArray=[])
    {
        $model =  static::find()->where($filter)->andWhere($andWhere)->orWhere($orWhere);
        if( $andWhereArray ){
            foreach ($andWhereArray as $v){
                $model->andWhere($v);
            }
        }
        return $model->count();

    }

}