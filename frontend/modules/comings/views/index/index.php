<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \common\repositories\DirectoriesRepository;
use \yii\helpers\ArrayHelper;
use \kartik\daterange\DateRangePicker;
use \common\repositories\MeasurementsRepository;
use \common\components\Icons;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ComingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Обращения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comings-repository-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить обращение', ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'source_id',
                'value' => function($data){
                    return $data['source'];
                },
                'filter' => Html::activeDropDownList($searchModel, 'source_id', ArrayHelper::map(
                        DirectoriesRepository::getPossibleDirectories(DirectoriesRepository::TYPE_COMING_SOURCE),
                    'id', 'name'), ['class'=>'form-control', 'prompt' => ''])
            ],
            [
                'attribute' => 'phone',
                'format' => 'raw',
                'value' => function($data) {
                        $html = '';
                        if (!$data['phones']) return null;
                        $phones = explode(',', $data['phones']);
                        foreach ($phones as $item) {
                            $html .= \common\repositories\PhonesRepository::phoneFormat($item, true) . '<br>';
                        }
                        return $html;
                    },
                'filter' => \yii\widgets\MaskedInput::widget([
                    'model' => $searchModel,
                    'name' => 'ComingsSearch[phone]',
                    'mask' => '(999) 999-9999',
                    'value' => htmlspecialchars($searchModel->phone)
                ])
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
                'template'=>'<div class="btn-group" role="group">{view}{measurement}{update}{delete}</div>',
                'buttons'=> [
                    'update' => function ($url, $model, $key) {
                        return Html::a(Icons::get(Icons::EDIT), ['update', 'id' => $key], [
                            'title' => Yii::t('app', 'Редактировать'),
                            'class' => 'btn btn-primary btn-xs'
                        ]);
                    },
                    'view' => function ($url, $model, $key) {
                        return "<a title='Открыть' href='" . \yii\helpers\Url::to(['view', 'id'=>$key]) . "' target='_blank' class='btn btn-xs btn-primary'>" . Icons::get(Icons::OPEN) . " открыть</a>";
                    },
                    'measurement' => function ($url, $model, $key) {
                        return "<a title='Создать замер' href='" . \yii\helpers\Url::to(['/measurements/calendar', 'id'=>$key, 'type' => MeasurementsRepository::FROM_COMING]) . "' target='_blank' class='btn btn-xs btn-primary'>" . Icons::get(Icons::MEASUREMENT) . " замер</a>";
                    },
                    'delete' => function ($url, $model, $key) {
                        return "<a title='Удалить' href='" . \yii\helpers\Url::to(['delete', 'id'=>$key]) . "' 
                            title='Удалить' data-pjax='0' data-confirm='Вы уверены, что хотите удалить этот элемент?' 
                            data-method='post' class='btn btn-danger btn-xs'>" . Icons::get(Icons::DELETE) . "</a>";
                    },
                ],
            ],
        ],
    ]); ?>
</div>
