<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 24.05.17
 * Time: 14:47
 */

namespace frontend\modules\settings\controllers;


use frontend\modules\settings\forms\CompanyForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;

class CompanyController extends Controller
{
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
            ],
        ];
    }

    public function actionIndex()
    {
        $company = CompanyForm::find()
            ->where(['id' => \Yii::$app->user->identity->company_id])
            ->one();

        if (!$company) {
            throw new HttpException(500, "Ошибка конфигурации. Обратитесь к администратору.");
        }

        if ($company->load(\Yii::$app->request->post()) && $company->validate()) {
            $company->save();
        }

        return $this->render('index', [
            'company' => $company
        ]);
    }
}