<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\repositories\OfficeRepository */

$this->title = 'Добавить офис';
$this->params['breadcrumbs'][] = ['label' => 'Офисы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-repository-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
