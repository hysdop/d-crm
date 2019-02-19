<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\repositories\DirectoriesRepository */

$this->title = 'Редактировать справочник: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Directories Repositories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="directories-repository-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
