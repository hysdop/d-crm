<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\repositories\CompanyRepository */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="company-repository-form">

    <?php $form = ActiveForm::begin(['enableClientValidation'=>false]); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '(999) 999-9999',
        'clientOptions' => [
            'removeMaskOnSubmit' => true,
        ]
    ]) ?>

    <?php echo $form->field($model, 'phone_second')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '(999) 999-9999',
        'clientOptions' => [
            'removeMaskOnSubmit' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'type')->dropDownList(\common\repositories\CompanyRepository::$TYPE_LIST) ?>

    <?php echo \common\components\fias\FiasWidget::widget([
        'model' => $model,
        'addressModel' => $model->addressModel,
        'attribute' => 'addressText',
        'form' => $form,
        'fields' => [
            'city_fias_id' => 'city_id',
            'region_fias_id' => 'region_id',
            'settlement_fias_id' => 'settlement_id',
            'street_fias_id' => 'street_id',
            'house_fias_id' => 'house_id',
            'postal_code',
            'unrestricted_value' => 'full'
        ]
    ]) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
