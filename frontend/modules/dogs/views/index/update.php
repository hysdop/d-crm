<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\repositories\DogsRepository */

$this->title = 'Редактировать договор #' . $model['id'];
$this->params['breadcrumbs'][] = ['label' => 'Договора', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="dogs-repository-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
