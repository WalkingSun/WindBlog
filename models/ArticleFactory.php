<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2018/12/18
 * Time: 18:02
 */

namespace app\models;


use yii\base\Model;
use yii\helpers\ArrayHelper;

class ArticleFactory
{
    static private $instance;

    private function __construct($config){

    }

    public static function init(array $config = [])
    {
        $type = $config['type']?:1;
        switch ($type){
            case 1:
                self::$instance = new ArtitleCnblogs();
                break;
            case 2:
                self::$instance = new ArtitleJuejin();
                break;
            default:
                break;
        }
        return self::$instance;
    }


}