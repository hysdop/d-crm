<?php

use yii\helpers\Html;
use common\components\detail\DetailView;
use  \common\repositories\MeasurementsRepository;
use common\components\Icons;

/* @var $this yii\web\View */
/* @var $model common\repositories\MeasurementsRepository */

$this->title = htmlspecialchars($model['firstname'] . ' ' . $model['lastname']);
$this->params['breadcrumbs'][] = ['label' => 'Замеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$labels = (new MeasurementsRepository())->attributeLabels();
?>
<div class="measurements-repository-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="pull-right">
        <?= Html::a(Icons::get(Icons::DOG) . ' Создать договор', ['/dogs/index/create', 'id' => $model['id'], 'type' => \common\repositories\DogsRepository::FROM_MEASUREMENT],
            [
               'class' => 'btn btn-primary',
               'title' => 'Создать договор'
            ]) ?>
        <?= Html::a(Icons::get(Icons::EDIT) . ' Изменить', ['update', 'id' => $model['id']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Icons::get(Icons::DELETE) . ' ', ['delete', 'id' => $model['id']], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить замер?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'subHeader' => true,
                'value' => 'Информация о клиенте',
                'captionOptions' => ['class' => 'text-center'],
                'rowOptions' => ['style' => 'background-color: #c7dbff;']
            ],
            [
                'attribute' => 'firstname',
                'label' => 'ФИО',
                'value' => function($data) {
                    return htmlspecialchars($data['firstname'] . ' ' . $data['lastname'] . ' ' . $data['middlename']);
                },
            ],
            [
                'label' => 'Телефон',
                'format' => 'raw',
                'value' => function($data) {
                    $html = '';
                    foreach ($data['phones'] as $item) {
                        $html .= \common\repositories\PhonesRepository::phoneFormat($item['phone'], true) . "<br>";
                    }
                    return $html;
                }
            ],
            [
                'attribute' => 'client_id',
                'label' => $labels['client_id'],
                'format' => 'raw',
                'value' => Html::a('Открыть', ['/clients/index/view', 'id' => $model['client_id']], [
                    'title' => 'Открыть профиль клиента',
                    'class' => 'btn btn-primary',
                ]),
                'visible' => $model['client_id'] > 0
            ],

            [
                'subHeader' => true,
                'value' => 'Замер',
                'captionOptions' => ['class' => 'text-center'],
                'rowOptions' => ['style' => 'background-color: #c7dbff;']
            ],
            [
                'attribute' => 'address_id',
                'label' => $labels['address_id'],
                'format' => 'raw',
                'value' => '<b style="color: #191919">' . htmlspecialchars($model['address']) . '</b>'
            ],
            [
                'label' => 'Дата/Время',
                'format' => 'raw',
                'value' => '<b style="color: #191919">' . Yii::$app->formatter->asDate($model['date']) . ' ' . Yii::$app->formatter->asTime($model['time']) . '</b>'
            ],
            [
                'attribute' => 'constructions',
                'label' => $labels['constructions'],
                'format' => 'integer'
            ],
            [
                'label' => 'Сотрудник',
                'value' => $model['employeeName']
            ],
            [
                'label' => $labels['status'],
                'attribute' => 'status',
                'format' => 'raw',
                'value' => MeasurementsRepository::getStatusName($model['status']),
            ],

            [
                'subHeader' => true,
                'value' => 'Дополнительная информация',
                'captionOptions' => ['class' => 'text-center'],
                'rowOptions' => ['style' => 'background-color: #c7dbff;']
            ],
            [
                'label' => 'Менеджер',
                'value' => $model['managerName']
            ],
            [
                'attribute' => 'created_at',
                'label' => $labels['created_at'],
                'format' => 'datetime',
            ],
            [
                'attribute' => 'updated_at',
                'label' => $labels['updated_at'],
                'format' => 'datetime',
                'visible' => (($model['updated_at'] > 0) && ($model['updated_at'] != $model['created_at']))
            ],
        ],
    ]) ?>

</div>
