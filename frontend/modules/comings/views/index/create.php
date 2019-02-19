<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\repositories\ComingsRepository */

$this->title = 'Новое обращение';
$this->params['breadcrumbs'][] = ['label' => 'Обращение', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comings-repository-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
