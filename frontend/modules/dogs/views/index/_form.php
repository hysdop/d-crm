<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\BaseHtml;
use unclead\multipleinput\TabularInput;

/* @var $this yii\web\View */
/* @var $model common\repositories\DogsRepository */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dogs-repository-form">

    <?php $form = ActiveForm::begin(['id' => 'dog-form',
            'enableClientValidation' => false,
            'options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel mypanel">
                <div class="panel-heading"><h3 class="panel-title">Личные данные</h3></div>
                <div class="panel-body">
                    <div class="row">
                        <?php echo $form->field($model, 'lastname', [
                            'options' => ['class' => 'col-md-4 col-sm-4 col-xs-4 form-group'],
                            'template' => "{label}\n{input}\n{hint}\n{error}",
                            'labelOptions' => ['class' => '']
                        ])->textInput(['class' => 'form-control']) ?>

                        <?php echo $form->field($model, 'firstname', [
                            'options' => ['class' => 'col-md-4 col-sm-4 col-xs-4 form-group'],
                            'template' => "{label}\n{input}\n{hint}\n{error}",
                            'labelOptions' => ['class' => '']
                        ])->textInput(['class' => 'form-control']) ?>

                        <?php echo $form->field($model, 'middlename', [
                            'options' => ['class' => 'col-md-4 col-sm-4 col-xs-4 form-group'],
                            'template' => "{label}\n{input}\n{hint}\n{error}",
                            'labelOptions' => ['class' => '']
                        ])->textInput(['class' => 'form-control']) ?>
                    </div>

                    <div class="row">
                        <?php echo \common\components\fias\FiasWidget::widget([
                            'model' => $model,
                            'form' => $form,
                            'addressModel' => $model->addressModel,
                            'attribute' => 'addressText',
                            'options' => [
                                'label' => 'Адрес'
                            ],
                            'optionsField' => [
                                'template' => "{label}\n{input}\n{hint}\n{error}",
                                'labelOptions' => ['class' => ''],
                                'options' => ['class' => 'col-md-4 col-sm-4 col-xs-4 form-group']
                            ],
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

                        <div class="col-md-4 col-sm-4 col-xs-4 form-group has-success">
                            <label>Телефон</label>
                            <div class=" ">
                                <?php echo TabularInput::widget([
                                    'form' => $form,
                                    'max' => 4,
                                    'models' => $model->phonesItems,
                                    'attributeOptions' => [
                                        'enableClientValidation'    => false,
                                    ],
                                    'columns' => [
                                        [
                                            'name' => 'phone',
                                            'type' => \yii\widgets\MaskedInput::class,
                                            'options' => [
                                                'mask' => '(999) 999-9999',
                                                'clientOptions' => ['removeMaskOnSubmit' => true,],
                                                'options' => ['class' => 'form-control']
                                            ],
                                            'attributeOptions' => [],
                                            'enableError' => true
                                        ],
                                    ],
                                ]); ?>
                            </div>
                            <div class="has-error">
                                <div class="help-block"><?php echo BaseHtml::error($model, 'phonesItems') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel mypanel">
                <div class="panel-heading"><h3 class="panel-title">Договор</h3></div>
                <div class="panel-body">
                    <?= $form->field($model, 'sum', [
                        'options' => ['class' => 'col-md-4 col-sm-4 col-xs-4 form-group'],
                        'template' => "{label}\n{input}\n{hint}\n{error}",
                        'labelOptions' => ['class' => '']
                    ])->textInput() ?>

                    <?= $form->field($model, 'discount', [
                        'options' => ['class' => 'col-md-4 col-sm-4 col-xs-4 form-group'],
                        'template' => "{label}\n{input}\n{hint}\n{error}",
                        'labelOptions' => ['class' => '']
                    ])->textInput() ?>

                    <?= $form->field($model, 'text', [
                        'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group'],
                        'template' => "{label}\n{input}\n{hint}\n{error}",
                        'labelOptions' => ['class' => '']
                    ])->textarea(['rows' => 6]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style type="text/css">
    .mypanel{
        border: 1px solid #aac1e4;
    }
    .mypanel .panel-heading{
        font-weight: bold;
        font-size: 14px;
    }
    .mypanel .panel-heading{
        border-bottom: 1px solid #b8d1f7;
        background-color: #c7dbff;
    }
    .suggestions-wrapper{

    }
</style>