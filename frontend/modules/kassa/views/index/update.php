<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\repositories\KassaInRepository */

$this->title = 'Update Kassa In Repository: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kassa In Repositories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kassa-in-repository-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
