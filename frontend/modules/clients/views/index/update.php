<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\repositories\ClientsRepository */

$this->title = 'Редактировать: ' . htmlspecialchars($model->firstname . ' ' . $model->middlename . ' ' . $model->lastname);
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';

?>
<div class="clients-repository-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
