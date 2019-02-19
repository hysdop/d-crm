<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \common\repositories\DirectoriesRepository;
use \yii\helpers\ArrayHelper;
use \kartik\daterange\DateRangePicker;
use \common\repositories\ClientsRepository;
use \common\repositories\PhonesRepository;
use \common\repositories\MeasurementsRepository;

/* @var $this yii\web\View */
/* @var $searchModel \frontend\modules\clients\search\ClientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-repository-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php echo GridView::widget([
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
                'attribute' => 'phone',
                'format' => 'raw',
                'value' => function($data) {
                    $html = '';
                    $phones = explode(',', $data['phones']);
                    foreach ($phones as $item) {
                        $html .= PhonesRepository::phoneFormat($item, true) . "<br>";
                    }
                    return $html;
                },
                'filter' => \yii\widgets\MaskedInput::widget([
                        'model' => $searchModel,
                        'name' => 'ClientsSearch[phone]',
                        'mask' => '(999) 999-9999',
                        'value' => htmlspecialchars($searchModel->phone)
                ])
            ],
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function($data) {
                    return ClientsRepository::getTypeName($data['type']);
                },
                'filter' => Html::activeDropDownList($searchModel, 'type', ClientsRepository::$types, ['class'=>'form-control', 'prompt' => ''])
            ],
            [
                'attribute' => 'text',
                'format' => 'raw',
                'value' => function($data) {
                    $html = '<span title="' . htmlspecialchars($data['text']) .'">';
                    $html .= htmlspecialchars(\yii\helpers\StringHelper::truncate($data['text'], 20));
                    $html .= '</span>';
                    return $html;
                },
                'filter' => Html::activeTextInput($searchModel, 'text', ['class' => 'form-control'])
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
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $key], [
                            'title' => Yii::t('app', 'Редактировать'),
                            'class' => 'btn btn-primary btn-xs'
                        ]);
                    },
                    'view' => function ($url, $model, $key) {
                        return "<a title='Открыть' href='" . \yii\helpers\Url::to(['/clients/index/view', 'id'=>$key]) . "' target='_blank' class='btn btn-xs btn-primary'><span class='glyphicon glyphicon-eye-open'></span> открыть</a>";
                    },
                    'coming' => function ($url, $model, $key) {
                        return "<a title='Создать обращение' href='" . \yii\helpers\Url::to(['/measurements/calendar', 'id'=>$key, 'type' => MeasurementsRepository::FROM_CLIENT]) . "' target='_blank' class='btn btn-xs btn-primary'><span class='fa fa-crop'></span> замер</a>";
                    },
                    'measurement' => function ($url, $model, $key) {
                        return "<a title='Создать замер' href='" . \yii\helpers\Url::to(['/measurements/calendar', 'id'=>$key, 'type' => MeasurementsRepository::FROM_CLIENT]) . "' target='_blank' class='btn btn-xs btn-primary'><span class='fa fa-crop'></span> замер</a>";
                    },
                    'delete' => function ($url, $model, $key) {
                        return "<a title='Удалить' href='" . \yii\helpers\Url::to(['/clients/index/delete', 'id'=>$key]) . "' 
                            title='Удалить' data-pjax='0' data-confirm='Вы уверены, что хотите удалить этот элемент?' 
                            data-method='post' class='btn btn-danger btn-xs'>
                            <span class='glyphicon glyphicon-trash'></span></a>";
                    },
                ],
            ],
        ],
    ]); ?>
</div>