<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\repositories\DirectoriesRepository */

$this->title = 'Добавить справочник';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['/settings/index']];
$this->params['breadcrumbs'][] = ['label' => 'Справочники', 'url' => ['/settings/directories/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="directories-repository-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
