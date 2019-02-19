<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\repositories\DirectoriesRepository */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['/settings/index']];
$this->params['breadcrumbs'][] = ['label' => 'Справочники', 'url' => ['/settings/directories/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="directories-repository-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'type',
                'value' => function($data) {
                    return \common\repositories\DirectoriesRepository::getTypeName($data['type']);
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($data) {
                    return \common\repositories\DirectoriesRepository::getStatusNameColored($data['status']);
                }
            ],
            'sort',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
