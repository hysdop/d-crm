<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\repositories\DirectoriesRepository;
use yii\helpers\Url;
use yii\web\JsExpression;
use \yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model common\repositories\DirectoriesRepository */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="directories-repository-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'type')->dropDownList(DirectoriesRepository::$typesTree, ['class'=>'form-control', 'prompt' => '']) ?>

    <?php echo $form->field($model, 'name')->widget(AutoComplete::className(), [
        'options' => ['placeholder' => '', 'class' => 'form-control'],
        'clientOptions' => [
            'serviceUrl' => Url::to(['/settings/ajax/autocomplete-directories']),
            'maxResults' => 5,
            'autoFill' => true,
            'dataType' => 'json',
            //'paramName' => 'phone',
            //'minLength' => '0',
            'transformResult' => new JsExpression('function (response) {
                                return {
                                    suggestions: $.map(response, function (value, key) {
                                        return { value: value.name};
                                    })
                                };
                            }
                        '),
            'select' => new JsExpression('function( event, ui ) {
                        // $( "#Sborka" ).val( ui.item.name + " / " + ui.item.blok_num );
                    return false;}'),
        ],
    ]); ?>

    <?php echo $form->field($model, 'status', [
        'options' => ['class' => ''],
        'template' => "{label}\n{input}\n{hint}\n{error}",
        'labelOptions' => ['class' => '']
    ])->widget(\common\components\autoradio\AutoRadioWidget::className(), [
        'form' => $form,
        'options' => ['label' => false],
        'selectAfter' => 3,
        'nullOption' => true,
        'items' => \common\repositories\DirectoriesRepository::$statuses
    ]) ?>

    <?php //echo $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
