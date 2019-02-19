<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \common\repositories\DirectoriesRepository;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Справочники';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['/settings/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="directories-repository-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($data) {
                    return '<b>' . htmlspecialchars($data['name']) . '</b>';
                }
            ],
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function($data) {
                    return DirectoriesRepository::getTypeName($data['type'], true);
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
                'filter' => false
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'<div class="btn-group" role="group">{view}{update}{block}{delete}</div>',
                'buttons'=> [
                    'view' => function ($url, $model, $key) {
                        return "<a title='Открыть' href='" . \yii\helpers\Url::to(['view', 'id'=>$key]) . "' target='_blank' class='btn btn-xs btn-primary'><span class='glyphicon glyphicon-eye-open'></span> открыть</a>";
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $key], [
                            'title' => Yii::t('app', 'Редактировать'),
                            'class' => 'btn btn-primary btn-xs'
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $key], [
                            'title' => 'Удалить',
                            'data-pjax',
                            'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                            'data-method' => 'post',
                            'class' => 'btn btn-danger btn-xs'
                        ]);
                    },
                    'block' => function ($url, $model, $key) {
                        if (in_array($model['status'],  [DirectoriesRepository::STATUS_ACTIVE])) {
                            return Html::a('<span class="glyphicon glyphicon-off"></span>', ['block', 'id' => $key], [
                                'title' => 'Отключить',
                                'data-pjax',
                                'data-confirm' => 'Отключить справочник?',
                                'data-method' => 'post',
                                'class' => 'btn btn-warning btn-xs'
                            ]);
                        } elseif (in_array($model['status'],  [DirectoriesRepository::STATUS_DISABLED, DirectoriesRepository::STATUS_DELETED])) {
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', ['unblock', 'id' => $key], [
                                'title' => 'Активировать',
                                'data-pjax',
                                'data-confirm' => 'Включить справочник?',
                                'data-method' => 'post',
                                'class' => 'btn btn-success btn-xs'
                            ]);
                        }
                        return null;
                    }
                ],
            ],
        ],
    ]); ?>
</div>
