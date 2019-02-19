<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\repositories\MeasurementsRepository */

$this->title = 'Редактировать замер #' . $model['id'];
$this->params['breadcrumbs'][] = ['label' => 'Замеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="measurements-repository-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'employee' => $employee,
        'employees' => $employees
    ]) ?>

</div>
