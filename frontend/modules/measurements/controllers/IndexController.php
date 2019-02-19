<?php

namespace frontend\modules\measurements\controllers;

use common\repositories\AddressRepository;
use common\repositories\ClientsRepository;
use common\repositories\ComingsRepository;
use common\repositories\CompanyRepository;
use common\repositories\PhonesRepository;
use common\repositories\UserProfileRepository;
use common\repositories\UserRepository;
use frontend\modules\measurements\forms\MeasurementsForm;
use Yii;
use common\repositories\MeasurementsRepository;
use frontend\modules\measurements\search\SearchMeasurements;
use yii\db\Expression;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IndexController implements the CRUD actions for MeasurementsRepository model.
 */
class IndexController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all MeasurementsRepository models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchMeasurements();
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
            ->select(new Expression('a.full address, 
                concat(p.`firstname`, \' \', p.lastname) managerName, 
                concat(p2.`firstname`, \' \', p2.lastname) employeeName, 
                m.*'))
            ->from(MeasurementsRepository::tableName() . ' m')
            ->leftJoin('{{%address}} a', 'a.obj_id = m.id AND a.type = ' . AddressRepository::TYPE_MEASUREMENT)
            ->leftJoin('{{%user_profile}} p', 'p.user_id = m.user_id')
            ->leftJoin('{{%user_profile}} p2', 'p2.user_id = m.employee_id')
            ->where([
                'm.id' => $id,
                'company_id' => Yii::$app->user->identity->company_id
            ])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('Замер не найден или нет доступа');
        }

        $model['phones'] = PhonesRepository::getPhones(PhonesRepository::TYPE_MEASUREMENT, $id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate($id, $type, $uid, $date)
    {
        $model = new MeasurementsForm();
        $model->status = MeasurementsRepository::STATUS_PLANNED;
        $model->company_id = Yii::$app->user->identity->company_id;
        $model->user_id = Yii::$app->user->id;
        $model->employee_id = $uid;
        $model->date = $date;

        if ($id) {
            $from = $model->loadFrom($type, $id);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $employee = (new Query())
                ->select(new Expression('concat(p.`firstname`, \' \', p.lastname) employeeName, u.username'))
                ->from(UserRepository::tableName() . ' u')
                ->innerJoin(UserProfileRepository::tableName() . ' p', 'u.id = p.user_id')
                ->where(['p.user_id' => $uid])
                ->one();

            $model->fillAvailableTimesList();

            return $this->render('create', [
                'model' => $model,
                'employee' => $employee,
                'from' => $from,
                'fromType' => $type,
                'employees' => CompanyRepository::getEmployees(Yii::$app->user->identity->company_id)
            ]);
        }
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($id)
    {
        $model = MeasurementsForm::find()
            ->where(['id' => $id])
            ->one();

        if (!$model) {
            throw new ForbiddenHttpException();
        }

        $employee = (new Query())
            ->select(new Expression('concat(p.`firstname`, \' \', p.lastname) employeeName'))
            ->from(UserProfileRepository::tableName() . ' p')
            ->innerJoin(UserRepository::tableName() . ' u', 'u.id = p.user_id')
            ->where(['user_id' => $model->employee_id])
            ->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->fillAvailableTimesList();

            return $this->render('update', [
                'model' => $model,
                'employee' => $employee,
                'employees' => CompanyRepository::getEmployees(Yii::$app->user->identity->company_id)
            ]);
        }
    }

    /**
     * @param $id
     * @return MeasurementsRepository
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $model = MeasurementsRepository::find()
            ->where(['id' => $id])
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Объект не найден или нет доступа');
        }
    }
}
