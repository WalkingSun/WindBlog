<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2018/11/6
 * Time: 14:50
 */

namespace app\commands;


use app\models\ArticleFactory;
use yii\console\Controller;

class AutosyncController extends Controller
{

    public function actionIndex(){
        $gitUser = \Yii::$app->params['gitUser'];
        $Repositories = \Yii::$app->params['Repositories'];
        $url = "https://github.com/{$gitUser}/{$Repositories}/file-list/gh-pages/_posts";
        ArticleFactory::init(['type'=>4])->pull($url);
    }


}