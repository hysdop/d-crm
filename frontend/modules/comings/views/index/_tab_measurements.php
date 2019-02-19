<?php

use common\components\detail\DetailView;
use common\repositories\MeasurementsRepository;
use yii\helpers\Html;

/** @var $measurements array */

$labels = (new \common\repositories\MeasurementsRepository())->attributeLabels();

$i = count($measurements);
?>

<?php foreach ($measurements as $item): ?>
    <?= DetailView::widget([
        'model' => $item,
        'attributes' => [
            [
                'subHeader' => true,
                'value' => 'Замер #' . $item['id'],
                'captionOptions' => ['class' => 'text-center'],
                'rowOptions' => ['style' => 'background-color: #c7dbff;']
            ],
            'name' => [
                'attribute' => 'firstname',
                'label' => $isFiz ? 'ФИО' : 'Наименование организации',
                'value' => function($data) {
                    return htmlspecialchars($data['firstname'] . ' ' . $data['lastname'] . ' ' . $data['middlename']);
                },
            ],
            [
                'attribute' => 'status',
                'label' => $labels['status'],
                'format' => 'raw',
                'value' => MeasurementsRepository::getStatusNameWithIcon($item['status']),
            ],
            [
                'label' => 'Дата/Время',
                'attribute' => 'date',
                'format' => 'raw',
                'value' => Yii::$app->formatter->asDate($item['date']) . ' ' . Yii::$app->formatter->asTime($item['time'])
            ],
            [
                'label' => $labels['constructions'],
                'attribute' => 'constructions',
                'format' => 'integer',
            ],
            [
                'label' => 'Менеджер',
                'value' => $item['managerName']
            ],
            [
                'label' => 'Сотрудник',
                'value' => $item['employeeName']
            ],
            [
                'label' => $labels['address_id'],
                'attribute' => 'address_id',
                'format' => 'raw',
                'value' => htmlspecialchars($item['address'])
            ],
            [
                'label' => $labels['created_at'],
                'attribute' => 'created_at',
                'format' => 'datetime',
            ],
            [
                'label' => $labels['updated_at'],
                'attribute' => 'created_at',
                'format' => 'datetime',
                'visible' => (($item['updated_at'] > 0) && ($item['updated_at'] != $item['updated_at']))
            ],
            [
                'label' => '',
                'format' => 'raw',
                'value' => function($data) {
                    $html = '';
                    $html .= Html::a('Открыть', ['/measurements/index/view', 'id' => $data['id']], ['class' => 'btn btn-primary']);
                    return $html;
                }
            ],
        ]
    ]); ?>
<?php endforeach; ?>
