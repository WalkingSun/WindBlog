<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2018/11/6
 * Time: 14:50
 */

namespace app\commands;


use yii\web\Controller;

class AutosyncController extends Controller
{

    public function actionIndex(){
        $gitUser = \Yii::$app->params['gitUser'];
        $Repositories = \Yii::$app->params['Repositories'];
        $url = "https://github.com/{$gitUser}/{$Repositories}/tree/gh-pages/_posts";


    }
}