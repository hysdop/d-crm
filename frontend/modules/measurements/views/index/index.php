<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \kartik\daterange\DateRangePicker;
use \common\repositories\PhonesRepository;
use \common\repositories\MeasurementsRepository;
use \common\repositories\CompanyRepository;
use \yii\helpers\ArrayHelper;
use common\components\Icons;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\measurements\search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Замеры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="measurements-repository-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //Html::a('Добавить замер', ['create'], ['class' => 'btn btn-success']) ?>
        <?php echo Html::a(Icons::get(Icons::CALENDAR) . ' Календарь', ['/measurements/calendar'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name' => [
                'attribute' => 'name',
                'value' => function($data) {
                    return htmlspecialchars($data['firstname'] . ' ' . $data['lastname'] . ' ' . $data['middlename']);
                }
            ],
            [
                'label' => 'Дата/Время',
                'format' => 'raw',
                'value' => function($data) {
                    return Yii::$app->formatter->asDate($data['date']) . ' ' . Yii::$app->formatter->asTime($data['time']);
                },
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date',
                    'options' => ['class' => 'form-control'],
                    'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd'
                ])
            ],
            [
                'label' => 'Сотрудник',
                'attribute' => 'employeeName',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'employee_id',
                    ArrayHelper::map(CompanyRepository::getEmployees(Yii::$app->user->identity->company_id),
                        'user_id', function($model, $defaultValue) {
                        return htmlspecialchars($model['firstname'].' '.$model['lastname']);
                    }),
                    ['class'=>'form-control', 'prompt' => ''])
            ],
            [
                'attribute' => 'created_at',
                'value' => function($data){
                    return Yii::$app->formatter->asDatetime($data['created_at']);
                },
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'dateRange',
                    'startAttribute'=>'dateFrom',
                    'endAttribute'=>'dateTo',
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'Y-m-d'
                        ],
                    ],
                ])
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'<div class="btn-group" role="group">{view}{dogs}{update}{delete}</div>',
                'buttons'=> [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $key], [
                            'title' => Yii::t('app', 'Редактировать'),
                            'class' => 'btn btn-primary btn-xs'
                        ]);
                    },
                    'view' => function ($url, $model, $key) {
                        return "<a title='Открыть' href='" . \yii\helpers\Url::to(['/measurements/index/view', 'id' => $key]) . "' target='_blank' class='btn btn-xs btn-primary'><span class='glyphicon glyphicon-eye-open'></span> открыть</a>";
                    },
                    'dogs' => function ($url, $model, $key) {
                        return "<a title='Создать договор' href='" . \yii\helpers\Url::to(['/dogs/index/create', 'id' => $key, 'type' => \common\repositories\DogsRepository::FROM_MEASUREMENT]) . "' target='_blank' class='btn btn-xs btn-primary'><span class='fa fa-briefcase'></span> договор</a>";
                    },
                    'delete' => function ($url, $model, $key) {
                        return "<a title='Удалить' href='" . \yii\helpers\Url::to(['/measurements/index/delete', 'id' => $key]) . "' 
                            title='Удалить' data-pjax='0' data-confirm='Вы уверены, что хотите удалить этот элемент?' 
                            data-method='post' class='btn btn-danger btn-xs'>
                            <span class='glyphicon glyphicon-trash'></span></a>";
                    },
                ],
            ],
        ],
    ]); ?>
</div>
