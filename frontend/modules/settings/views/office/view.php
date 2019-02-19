<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \common\repositories\PhonesRepository;
use \common\repositories\OfficeRepository;

/* @var $this yii\web\View */
/* @var $model common\repositories\OfficeRepository */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Офисы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-repository-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'attribute' => 'phone',
                'format' => 'raw',
                'value' => PhonesRepository::phoneFormat($model['phone'], true)
            ],
            [
                'attribute' => 'phone_second',
                'format' => 'raw',
                'value' => PhonesRepository::phoneFormat($model['phone_second'], true)
            ],
            [
                'attribute' => 'type',
                'value' => OfficeRepository::getTypeName($model['type'])
            ],
            [
                'attribute' => 'status',
                'value' => OfficeRepository::getStatusName($model['status'])
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
