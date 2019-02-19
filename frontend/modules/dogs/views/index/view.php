<?php

use yii\helpers\Html;
use common\components\detail\DetailView;
use common\repositories\PhonesRepository;
use common\components\Icons;
use common\repositories\DogsRepository;

/* @var $this yii\web\View */
/* @var $model common\repositories\DogsRepository */

$this->title = 'Договор #' . $model['id'];
$this->params['breadcrumbs'][] = ['label' => 'Договора', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$labels = (new \common\repositories\DogsRepository())->attributeLabels();

$isFiz = false;
?>
<div class="dogs-repository-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="pull-right">
        <?= Html::a(Icons::get(Icons::EDIT) . ' Изменить', ['update', 'id' => $model['id']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Icons::get(Icons::DELETE) . ' ', ['delete', 'id' => $model['id']], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить клиента?',
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
            'name' => [
                'attribute' => 'firstname',
                'label' => $isFiz ? 'ФИО' : 'Наименование организации',
                'value' => function($data) {
                    return htmlspecialchars($data['firstname'] . ' ' . $data['lastname'] . ' ' . $data['middlename']);
                },
            ],
            [
                'label' => 'Телефон',
                'format' => 'raw',
                'value' => function($model) {
                    $html = '';
                    foreach ($model['phones'] as $item) {
                        $html .= Icons::get(Icons::PHONE, 'green') . PhonesRepository::phoneFormat($item['phone']) . "<br>";
                    }
                    return $html;
                }
            ],
            [
                'label' => $labels['status'],
                'format' => 'raw',
                'value' => function($data) {
                    return DogsRepository::getStatusName($data['status']);
                }
            ],

            [
                'subHeader' => true,
                'value' => 'Договор',
                'captionOptions' => ['class' => 'text-center'],
                'rowOptions' => ['style' => 'background-color: #c7dbff;']
            ],
            [
                'label' => $labels['sum'],
                'value' => function($data) {
                    return $data['sum'];
                }
            ],
            [
                'label' => $labels['discount'],
                'value' => function($data) {
                    return ($data['discount'] ? : 0) . ' %';
                }
            ],
            [
                'label' => '',
                'format' => 'raw',
                'value' => function($data) {
                    $html = '';
                    $html .= Html::a(Icons::get(Icons::MEASUREMENT) . ' Показать замер', ['/measurements/index/view', 'id' => $data['measurement_id']], ['class' => 'btn btn-primary']);
                    return $html;
                }
            ],

            [
                'subHeader' => true,
                'value' => 'Дополнительная информация',
                'captionOptions' => ['class' => 'text-center'],
                'rowOptions' => ['style' => 'background-color: #c7dbff;']
            ],
            [
                'label' => $labels['user_id'],
                'value' => function($data) {
                    return $data['managerName'];
                }
            ],
            [
                'label' => $labels['text'],
                'value' => function($data) {
                    return $data['text'];
                }
            ],
            [
                'label' => $labels['created_at'],
                'value' => function($data) {
                    return Yii::$app->formatter->asDatetime($data['created_at']);
                }
            ],
            [
                'label' => $labels['updated_at'],
                'value' => function($data) {
                    return Yii::$app->formatter->asDatetime($data['updated_at']);
                },
                'visible' => (($model['updated_at'] > 0) && ($model['updated_at'] != $model['created_at']))
            ],
        ],
    ]) ?>

</div>
