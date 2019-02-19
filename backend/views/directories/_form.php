<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\repositories\DirectoriesRepository;

/* @var $this yii\web\View */
/* @var $model common\repositories\DirectoriesRepository */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="directories-repository-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'type')
        ->dropDownList(DirectoriesRepository::$typesTree, ['class'=>'form-control', 'prompt' => '']) ?>

    <?= $form->field($model, 'status')->dropDownList(DirectoriesRepository::$statuses) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
