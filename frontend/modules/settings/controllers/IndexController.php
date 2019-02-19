<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 03.05.17
 * Time: 16:26
 */

namespace frontend\modules\settings\controllers;


use common\repositories\DirectoriesRepository;
use frontend\forms\AddressForm;
use frontend\forms\CompanyForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class IndexController extends Controller
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

    public function actionIndex()
    {
        return $this->render('index', [
            'dirsTree' => DirectoriesRepository::$typesTree
        ]);
    }
}