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
    public static $blogs = [
        '1'  => '博客园',
        '2'  => '思否',
        '3'  => '掘金',
//        '4'  => '开源中国',
    ];

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
                self::$instance = new ArtitleSegment();
                break;
            case 3:
                self::$instance = new ArtitleJuejin();
                break;
            default:
                break;
        }
        return self::$instance;
    }

}