<?php

namespace frontend\modules\dogs\controllers;

use common\repositories\AddressRepository;
use common\repositories\PhonesRepository;
use frontend\modules\dogs\forms\DogForm;
use Yii;
use common\repositories\DogsRepository;
use frontend\modules\dogs\search\DogsSearch;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IndexController implements the CRUD actions for DogsRepository model.
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
     * Lists all DogsRepository models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DogsSearch();
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
            ->select(new Expression('d.*, a.full address, concat(p.`firstname`, \' \', p.lastname) managerName'))
            ->from('{{%dogs}} d')
            ->leftJoin('{{%address}} a', 'a.obj_id = d.id AND a.type = ' . AddressRepository::TYPE_DOG)
            ->leftJoin('{{%user_profile}} p', 'p.user_id = d.user_id')
            ->where([
                'd.id' => $id,
                'd.company_id' => Yii::$app->user->identity->company_id,
                'd.user_id' => Yii::$app->user->id
            ])
            ->one();
        if (!$model) {
            throw new NotFoundHttpException('Объект не найден, либо нет доступа');
        }

        $model['phones'] = PhonesRepository::getPhones(PhonesRepository::TYPE_DOG, $id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new DogsRepository model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id, $type)
    {
        $model = new DogForm();
        $model->user_id = Yii::$app->user->id;
        $model->company_id = Yii::$app->user->identity->company_id;
        $model->status = DogsRepository::STATUS_ACTIVE;

        if ($id) {
            $from = $model->loadFrom($type, $id);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'fromId' => $id,
                'fromType' => $type,
                'from' => $from,
                'fromType' => $type,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = DogForm::find()
            ->where([
                'id' => $id,
                'company_id' => Yii::$app->user->identity->company_id,
                'user_id' => Yii::$app->user->id
            ])->one();
        if ($model == null) {
            throw new NotFoundHttpException('Объект не найден, либо нет доступа');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DogsRepository model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = DogsRepository::STATUS_DELETED;
        $model->save(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the DogsRepository model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = DogsRepository::find()
            ->where([
                'id' => $id,
                'company_id' => Yii::$app->user->identity->company_id,
                'user_id' => Yii::$app->user->id
            ])->one();
        if (($model) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Объект не найден, либо нет доступа');
        }
    }
}
