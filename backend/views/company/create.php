<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\repositories\CompanyRepository */

$this->title = 'Добавить дилера';
$this->params['breadcrumbs'][] = ['label' => '', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-repository-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
