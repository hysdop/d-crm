<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\repositories\DirectoriesRepository */

$this->title = 'Редактирование справочника: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['/settings/index']];
$this->params['breadcrumbs'][] = ['label' => 'Справочники', 'url' => ['/settings/directories/index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="directories-repository-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
