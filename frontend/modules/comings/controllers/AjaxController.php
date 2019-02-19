<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 09.06.17
 * Time: 12:27
 */

namespace frontend\modules\comings\controllers;


use yii\db\Query;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;

class AjaxController extends Controller
{
    public function actionClientsByPhone($phone = '')
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $date = (new Query())
            ->select('c.*')
            ->from('{{%clients}} c')
            ->all();

        return $date;
    }
}