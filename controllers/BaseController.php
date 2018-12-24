<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2018/12/18
 * Time: 20:18
 */

namespace app\controllers;


use app\models\Common;
use yii\web\Response;
use yii;
class BaseController extends  yii\web\Controller
{
    public $data;
    public $user;
    public $userId;

    public function init()
    {

    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];
        $behaviors['verbFilter']['actions'] = ['*' => ['get', 'post']];
        return $behaviors;
    }

    //增加过滤器
    public function filterParams( $data ){
        if( $data ){
            foreach ( $data as $k=>$v ){
                if(!is_string($v)){
                   continue;
                }
                $data[$k] = trim(Common::filter($v));
            }
        }
        return $data;
    }

    public function beforeAction($action)
    {
        $controllerID = Yii::$app->controller->id;
        $actionID = Yii::$app->controller->action->id;
        $moduleID = Yii::$app->controller->module->id;

        //记录请求
        $request = array_merge(Yii::$app->request->get(),Yii::$app->request->post());
        Common::addLog('request.log',array($moduleID.'/'.$controllerID.'/'.$actionID,$request));

        $this->data = self::filterParams( $request );

        if( !Yii::$app->user->isGuest ){
            $this->user =  Yii::$app->user;
            $this->userId =  Yii::$app->user->identity->username=='super'?Yii::$app->user->identity->username:Yii::$app->user->identity->getId();
        }

        return parent::beforeAction($action);
    }

}