<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Icons;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\dogs\search\DogsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Договора';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dogs-repository-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
            'sum',
            'discount',
            [
                'attribute' => 'created_at',
                'value' => function($data){
                    return Yii::$app->formatter->asDatetime($data['created_at']);
                },
                'filter' => \kartik\daterange\DateRangePicker::widget([
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
                'template'=>'<div class="btn-group" role="group">{view}{update}{delete}</div>',
                'buttons'=> [
                    'update' => function ($url, $model, $key) {
                        return Html::a(Icons::get(Icons::EDIT), ['/dogs/index/update', 'id' => $key], [
                            'title' => Yii::t('app', 'Редактировать'),
                            'class' => 'btn btn-primary btn-xs'
                        ]);
                    },
                    'view' => function ($url, $model, $key) {
                        return "<a title='Открыть' href='" . Url::to(['view', 'id'=>$key]) . "' target='_blank' class='btn btn-xs btn-primary'>" . Icons::get(Icons::OPEN) . " открыть</a>";
                    },
                    'delete' => function ($url, $model, $key) {
                        return "<a title='Удалить' href='" . Url::to(['delete', 'id'=>$key]) . "' 
                            title='Удалить' data-pjax='0' data-confirm='Вы уверены, что хотите удалить этот элемент?' 
                            data-method='post' class='btn btn-danger btn-xs'>" . Icons::get(Icons::DELETE) . "</a>";
                    },
                ],
            ],
        ],
    ]); ?>
</div>
