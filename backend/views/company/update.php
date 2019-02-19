<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\repositories\CompanyRepository */

$this->title = 'Редактирование: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Дилеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="company-repository-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
