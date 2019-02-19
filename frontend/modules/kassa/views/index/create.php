<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\repositories\KassaInRepository */

$this->title = 'Create Kassa In Repository';
$this->params['breadcrumbs'][] = ['label' => 'Kassa In Repositories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kassa-in-repository-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
