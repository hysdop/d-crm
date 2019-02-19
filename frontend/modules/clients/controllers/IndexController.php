<?php

namespace frontend\modules\clients\controllers;

use common\repositories\AddressRepository;
use common\repositories\PhonesRepository;
use frontend\modules\clients\forms\ClientForm;
use Yii;
use common\repositories\ClientsRepository;
use frontend\modules\clients\search\ClientsSearch;
use yii\db\Expression;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientsController implements the CRUD actions for ClientsRepository model.
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

    /**
     * Lists all ClientsRepository models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        $model = (new Query())
            ->select(new Expression('a.full address, 
                concat(p.`firstname`, \' \', p.lastname) managerName, 
                u.username,
                r.*, c.*'))
            ->from(ClientsRepository::tableName() . ' c')
            ->leftJoin('{{%address}} a', 'a.obj_id = c.id AND a.type = ' . AddressRepository::TYPE_CLIENT)
            ->leftJoin('{{%user}} u', 'u.id = c.user_id')
            ->leftJoin('{{%user_profile}} p', 'p.user_id = c.user_id')
            ->leftJoin('{{%clients_requisites}} r', 'r.client_id = c.id')
            ->where([
                'c.id' => $id,
                'c.company_id' => Yii::$app->user->identity->company_id
            ])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('Клиент не найден или нет доступа');
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
            ->where(['client_id' => $model['id']])
            ->all();

        $comings = (new Query())
            ->select(new Expression('c.*, d1.name sourceName, d2.name typeName, d3.name actionName, d4.name forecastName,
                      a.full address, concat(p.`firstname`, \' \', p.lastname) userName'))
            ->from('{{%comings}} c')
            ->leftJoin('{{%directories}} d1', 'c.source_id = d1.id')
            ->leftJoin('{{%directories}} d2', 'c.type_id = d2.id')
            ->leftJoin('{{%directories}} d3', 'c.expected_action_id = d3.id')
            ->leftJoin('{{%directories}} d4', 'c.buy_forecast_id = d4.id')
            ->leftJoin('{{%address}} a', 'a.obj_id = c.id AND a.type = ' . AddressRepository::TYPE_COMING)
            ->leftJoin('{{%user_profile}} p', 'c.user_id = p.user_id')
            ->where(['c.client_id' => $id])
            ->all();

        $dogs = (new Query())
            ->select(new Expression('d.*, a.full address, concat(p.`firstname`, \' \', p.lastname) managerName'))
            ->from('{{%dogs}} d')
            ->leftJoin('{{%address}} a', 'a.obj_id = d.id AND a.type = ' . AddressRepository::TYPE_DOG)
            ->leftJoin('{{%user_profile}} p', 'p.user_id = d.user_id')
            ->where([
                'd.id' => $id,
                'd.company_id' => Yii::$app->user->identity->company_id,
                'd.user_id' => Yii::$app->user->id
            ])
            ->all();

        $model['phones'] = PhonesRepository::getPhones(PhonesRepository::TYPE_CLIENT, $id);
        $model['phones'] = $model['phones']  ? : [];

        return $this->render('view', [
            'model' => $model,
            'measurements' => $measurements,
            'comings' => $comings,
            'dogs' => $dogs
        ]);
    }

    /**
     * Creates a new ClientsRepository model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type = ClientForm::TYPE_FIZ)
    {
        $model = new ClientForm();
        if ($type == ClientForm::SCENARIO_FIZ) {
            $model->scenario = ClientForm::SCENARIO_FIZ;
            $model->type = ClientsRepository::TYPE_FIZ;
        } else {
            $model->scenario = ClientForm::SCENARIO_UR;
            $model->type = ClientsRepository::TYPE_UR;
        }
        $model->user_id = Yii::$app->user->id;
        $model->status = ClientsRepository::STATUS_ACTIVE;
        $model->company_id = Yii::$app->user->identity->company_id;

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ClientsRepository model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->type == ClientForm::SCENARIO_FIZ) {
            $model->scenario = ClientForm::SCENARIO_FIZ;
            $model->type = ClientsRepository::TYPE_FIZ;
        } else {
            $model->scenario = ClientForm::SCENARIO_UR;
            $model->type = ClientsRepository::TYPE_UR;
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save(false)) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = ClientsRepository::find()
            ->where(['id' => $id])
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->andWhere(['status' => ClientsRepository::STATUS_ACTIVE])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('Нет объекта или доступа');
        }

        $model->status = ClientsRepository::STATUS_DELETED;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ClientsRepository model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClientsRepository the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClientForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
