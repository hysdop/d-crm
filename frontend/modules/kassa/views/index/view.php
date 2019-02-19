<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\repositories\KassaInRepository */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kassa In Repositories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kassa-in-repository-view">

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
            'sum',
            'type',
            'status',
            'user_id',
            'employee_id',
            'dog_id',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
