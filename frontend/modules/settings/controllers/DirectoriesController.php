<?php

namespace frontend\modules\settings\controllers;

use frontend\modules\settings\forms\SettingsDirectoryForm;
use frontend\modules\settings\search\DirectoriesSearch;
use Yii;
use common\repositories\DirectoriesRepository;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DirectoriesController implements the CRUD actions for DirectoriesRepository model.
 */
class DirectoriesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
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

    /**
     * Lists all DirectoriesRepository models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DirectoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Displays a single DirectoriesRepository model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DirectoriesRepository model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SettingsDirectoryForm();
        $model->company_id = Yii::$app->user->identity->company_id;
        $model->status = DirectoriesRepository::STATUS_ACTIVE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'DirectoriesSearch' => ['type' => $model->type]]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DirectoriesRepository model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'DirectoriesSearch' => ['type' => $model->type]]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DirectoriesRepository model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = DirectoriesRepository::STATUS_DELETED;
        $model->save();

        return $this->redirect(['index']);
    }

    public function actionBlock($id) {
        $model = $this->findModel($id);
        $model->status = DirectoriesRepository::STATUS_DISABLED;
        $model->save();

        return $this->redirect(['index', 'DirectoriesSearch' => ['type' => $model->type]]);
    }

    public function actionUnblock($id) {
        $model = $this->findModel($id);
        $model->status = DirectoriesRepository::STATUS_ACTIVE;
        $model->save();

        return $this->redirect(['index',
            'DirectoriesSearch' => ['type' => $model->type]
        ]);
    }

    /**
     * Finds the DirectoriesRepository model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DirectoriesRepository the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = SettingsDirectoryForm::find()
            ->where(['id' => $id])
            ->andWhere(['company_id' => Yii::$app->user->identity->company_id])
            ->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
