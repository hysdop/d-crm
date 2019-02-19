<?php

namespace frontend\modules\comings\controllers;

use common\repositories\AddressRepository;
use common\repositories\ClientsRepository;
use common\repositories\MeasurementsRepository;
use frontend\modules\comings\forms\ComingForm;
use Yii;
use common\repositories\ComingsRepository;
use frontend\modules\comings\search\ComingsSearch;
use yii\db\Expression;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\repositories\PhonesRepository;

/**
 * ComingsController implements the CRUD actions for ComingsRepository model.
 */
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
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    // DELETE
    protected function actionEdit($id = 0)
    {
        $model = null;
        if ($id === 0) {
            $model = new ComingForm();
            $model->user_id = Yii::$app->user->id;
            $model->status = ComingsRepository::STATUS_ACTIVE;
            $model->company_id = Yii::$app->user->identity->company_id;
        } else {
            $model = ComingForm::find()
                ->where(['id' => $id])
                ->andWhere(['user_id' => Yii::$app->user->identity->id])
                ->andWhere(['status' => ComingsRepository::STATUS_ACTIVE])
                ->one();
        }

        if (!$model) {
            throw new NotFoundHttpException('Обращение не найдено или нет доступа');
        }

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save(false)) {
                Yii::$app->session->setFlash('alert', [
                    'body'=> 'Сохранено',
                    'options'=>['class'=>'alert-success']
                ]);
                if ($model->measurementBtn) {
                    return $this->redirect(['/measurements/index/create',
                        'type' => MeasurementsRepository::FROM_COMING,
                        'id' => $model->id
                    ]);
                } else {
                    return $this->redirect(['index']);
                }
            } else {
                Yii::$app->session->setFlash('alert', [
                    'body'=> 'Не удалось сохранить',
                    'options'=>['class'=>'alert-error']
                ]);
            }
        }

        return $this->render('edit', [
            'model' => $model
        ]);
    }

    /**
     * Lists all ComingsRepository models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ComingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = (new Query())
            ->select(new Expression('c.*, d1.name sourceName, d2.name typeName, d3.name actionName, d4.name forecastName,
                      a.full address, concat(p.`firstname`, \' \', p.lastname) userName'))
            ->from('{{%comings}} c')
            ->leftJoin('{{%directories}} d1', 'c.source_id = d1.id')
            ->leftJoin('{{%directories}} d2', 'c.type_id = d2.id')
            ->leftJoin('{{%directories}} d3', 'c.expected_action_id = d3.id')
            ->leftJoin('{{%directories}} d4', 'c.buy_forecast_id = d4.id')
            ->leftJoin('{{%address}} a', 'a.obj_id = c.id AND a.type = ' . AddressRepository::TYPE_COMING)
            ->leftJoin('{{%user_profile}} p', 'c.user_id = p.user_id')
            ->where(['c.id' => $id])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('Обращение не найдено или нет доступа');
        }

        $measurements = (new Query())
            ->select(new Expression('a.full address, 
                concat(p.`firstname`, \' \', p.lastname) managerName, 
                concat(p2.`firstname`, \' \', p2.lastname) employeeName, 
                m.*'))
            ->from('{{%measurements}} m')
            ->leftJoin('{{%address}} a', 'a.obj_id = m.id AND a.type = ' . AddressRepository::TYPE_MEASUREMENT)
            ->leftJoin('{{%user_profile}} p', 'p.user_id = m.user_id')
            ->leftJoin('{{%user_profile}} p2', 'p2.user_id = m.employee_id')
            ->where([
                'from_id' => $model['id'],
                'from' => MeasurementsRepository::FROM_COMING
            ])
            ->all();

        $model['phones'] = PhonesRepository::getPhones(PhonesRepository::TYPE_COMING, $id);

        return $this->render('view', [
            'model' => $model,
            'measurements' => $measurements
        ]);
    }

    public function actionCreate($clientId = null)
    {
        $model = new ComingForm();

        if ($clientId) {
            $client = ClientsRepository::find()
                ->where([
                    'id' => $clientId,
                    'user_id' => Yii::$app->user->id,
                    'company_id' => Yii::$app->user->identity->company_id
                ])
                ->asArray()
                ->one();
            if (!$client) {
                throw new NotFoundHttpException('Клиент не найден, либо нет доступа');
            }
            $model->loadFrom($client);
        }

        $model->user_id = Yii::$app->user->id;
        $model->status = ComingsRepository::STATUS_ACTIVE;
        $model->company_id = Yii::$app->user->identity->company_id;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save(false)) {
                Yii::$app->session->setFlash('alert', [
                    'body'=> 'Сохранено',
                    'options'=>['class'=>'alert-success']
                ]);
                if ($model->measurementBtn) {
                    return $this->redirect(['/measurements/calendar',
                        'type' => MeasurementsRepository::FROM_COMING,
                        'id' => $model->id
                    ]);
                } else {
                    return $this->redirect(['index']);
                }
            } else {
                Yii::$app->session->setFlash('alert', [
                    'body'=> 'Не удалось сохранить',
                    'options'=>['class'=>'alert-error']
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ComingsRepository model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = ComingForm::find()
            ->where(['id' => $id])
            ->andWhere(['user_id' => Yii::$app->user->identity->id])
            ->andWhere(['status' => ComingsRepository::STATUS_ACTIVE])
            ->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ComingsRepository model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ComingsRepository model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ComingsRepository the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ComingsRepository::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}