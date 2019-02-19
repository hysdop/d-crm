<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 09.06.17
 * Time: 16:21
 */

namespace frontend\modules\settings\controllers;


use yii\db\Expression;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class AjaxController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['boss']
                    ]
                ]
            ]
        ];
    }

    public function actionAutocompleteDirectories($query)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $date = (new Query())
            ->select(new Expression('DISTINCT d.name'))
            ->from('{{%directories}} d')
            ->where(['company_id' => \Yii::$app->user->identity->company_id])
            ->andWhere(['like', 'name', $query])
            ->all();

        return $date;
    }
}