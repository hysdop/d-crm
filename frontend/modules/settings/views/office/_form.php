<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\repositories\OfficeRepository;

/* @var $this yii\web\View */
/* @var $model common\repositories\OfficeRepository */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="office-repository-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '(999) 999-9999',
        'clientOptions' => [
            //'removeMaskOnSubmit' => true,
        ]
    ]) ?>

    <?php echo $form->field($model, 'phone_second')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '(999) 999-9999',
        'clientOptions' => [
            //'removeMaskOnSubmit' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'type')->dropDownList(OfficeRepository::$types) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
