<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\repositories\DirectoriesRepository;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\DirectoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Справочники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="directories-repository-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить справочник', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function($data) {
                    return DirectoriesRepository::getTypeName($data['type']);
                },
                'filter' => Html::activeDropDownList($searchModel, 'type', DirectoriesRepository::$typesTree, ['class'=>'form-control', 'prompt' => ''])
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($data) {
                    return DirectoriesRepository::getStatusNameColored($data['status']);
                },
                'filter' => Html::activeDropDownList($searchModel, 'status', DirectoriesRepository::$statuses, ['class'=>'form-control', 'prompt' => ''])
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => $searchModel,
                    'dateFormat' => 'yyyy-MM-dd',
                    'attribute' => 'created_at',
                    'options' => ['class'=>'form-control'],
                ])
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
