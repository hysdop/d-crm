<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \frontend\modules\clients\forms\ClientForm;
use yii\helpers\Url;
use \common\repositories\ClientsRepository;
use \unclead\multipleinput\TabularInput;
use \yii\helpers\BaseHtml;

/* @var $this yii\web\View */
/* @var $model \frontend\modules\clients\forms\ClientForm */
/* @var $form yii\widgets\ActiveForm */

$isFiz = ($model->scenario == ClientForm::SCENARIO_FIZ);

?>

<div class="clients-repository-form">
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-pills">
            <?php if ($model->isNewRecord): ?>
                <li class="<?= $isFiz ? 'active' : '' ?>">
                    <a href="<?= Url::to(['/clients/index/create']) ?>">Физ. лицо</a>
                </li>
                <li class="<?= !$isFiz ? 'active' : '' ?>">
                    <a href="<?= Url::to(['/clients/index/create', 'type' => ClientForm::SCENARIO_UR]) ?>">Юр. лицо</a>
                </li>
            <?php else: ?>
                <li class="not-selectable <?= $isFiz ? 'active' : '' ?>">
                    <a>Физ. лицо</a>
                </li>
                <li class="not-selectable <?= !$isFiz ? 'active' : '' ?>">
                    <a>Юр. лицо</a>
                </li>
            <?php endif; ?>
            </ul>
        </div>
    </div>

    <?php $form = ActiveForm::begin([
        'id' => 'client-form',
        //'enableClientValidation' => false,
        'options' => ['class' => 'form-horizontal form-label-left']
    ]);

    $phonesInputHtml = TabularInput::widget([
        'form' => $form,
        'max' => 4,
        'models' => $model->phonesModel->phonesItems,
        'attributeOptions' => [
            'enableClientValidation'    => false,
        ],
        'columns' => [
            [
                'name' => 'phone',
                'type' => \yii\widgets\MaskedInput::class,
                'options' => [
                    'mask' => '(999) 999-9999',
                    //'clientOptions' => ['removeMaskOnSubmit' => true,],
                    'options' => ['class' => 'form-control']
                ],
                'attributeOptions' => [],
                'enableError' => true
            ],
        ],
    ]);
    ?>

    <?php if ($isFiz): ?>
        <div class="row" style="margin-top: 20px;">
            <div class="col-lg-12">
                <div class="panel">
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
                            <div class="col-md-4 col-sm-4 col-xs-4 form-group has-success">
                                <label>Телефон</label>
                                <div class=" ">
                                    <?= $phonesInputHtml ?>
                                </div>
                                <div class="has-error">
                                    <div class="help-block"><?php echo BaseHtml::error($model, 'phonesItems') ?></div>
                                </div>
                            </div>

                            <?php echo $form->field($model, 'birthday', [
                                'options' => ['class' => 'col-md-4 col-sm-4 col-xs-4 form-group'],
                                'template' => "{label}\n{input}\n{hint}\n{error}",
                                'labelOptions' => ['class' => '']
                            ])->widget(\yii\jui\DatePicker::classname(), [
                                'options' => ['class' => 'form-control'],
                                'language' => 'ru',
                                'dateFormat' => 'yyyy-MM-dd',
                            ]) ?>

                            <?php echo $form->field($model, 'sex', [
                                'options' => ['class' => 'col-md-4 col-sm-4 col-xs-4'],
                                'template' => "{label}\n{input}\n{hint}\n{error}",
                                'labelOptions' => ['class' => '']
                            ])->widget(\common\components\autoradio\AutoRadioWidget::className(), [
                                'form' => $form,
                                'options' => ['label' => false],
                                'selectAfter' => 1,
                                'items' => ClientsRepository::$sexList
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-heading"><h3 class="panel-title">Паспортные данные</h3></div>
                    <div class="panel-body">
                        <?php echo $form->field($model, 'passport_series', [
                            'options' => ['class' => 'col-md-4 col-sm-4 col-xs-4 form-group'],
                            'template' => "{label}\n{input}\n{hint}\n{error}",
                            'labelOptions' => ['class' => '']
                        ])->textInput(['class' => 'form-control']) ?>

                        <?php echo $form->field($model, 'passport_number', [
                            'options' => ['class' => 'col-md-4 col-sm-4 col-xs-4 form-group'],
                            'template' => "{label}\n{input}\n{hint}\n{error}",
                            'labelOptions' => ['class' => '']
                        ])->textInput(['class' => 'form-control']) ?>

                        <?php echo $form->field($model, 'passport_date', [
                            'options' => ['class' => 'col-md-4 col-sm-4 col-xs-4 form-group'],
                            'template' => "{label}\n{input}\n{hint}\n{error}",
                            'labelOptions' => ['class' => '']
                        ])->widget(\yii\jui\DatePicker::classname(), [
                            'options' => ['class' => 'form-control'],
                            'language' => 'ru',
                            'dateFormat' => 'yyyy-MM-dd',
                        ]) ?>

                        <?php echo $form->field($model, 'passport_issue', [
                            'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group'],
                            'template' => "{label}\n{input}\n{hint}\n{error}",
                            'labelOptions' => ['class' => '']
                        ])->textInput(['class' => 'form-control']) ?>

                        <?php echo \common\components\fias\FiasWidget::widget([
                            'model' => $model,
                            'form' => $form,
                            'addressModel' => $model->addressModel,
                            'attribute' => 'addressText',
                            'options' => [
                                'label' => 'Прописка'
                            ],
                            'optionsField' => [
                                'template' => "{label}\n{input}\n{hint}\n{error}",
                                'labelOptions' => ['class' => ''],
                                'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group']
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
                    </div>
                </div>
            </div>
        </div>

        <?php else:  // Юр. лицо ?>

        <div class="row" style="margin-top: 20px;">
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-heading"><h3 class="panel-title">Основные данные</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <?php echo $form->field($model, 'firstname', [
                                'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group'],
                                'template' => "{label}\n{input}\n{hint}\n{error}",
                                'labelOptions' => ['class' => '']
                            ])->textInput(['class' => 'form-control'])->label('Наименование организации') ?>
                        </div>

                        <label>Телефон</label>
                        <div class=" ">
                            <?= $phonesInputHtml ?>
                        </div>
                        <div class="has-error">
                            <div class="help-block"><?php echo BaseHtml::error($model, 'phonesItems') ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-heading"><h3 class="panel-title">Реквизиты</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <?php echo $form->field($model->clientsRequisitesModel, 'bank', [
                                'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group'],
                                'template' => "{label}\n{input}\n{hint}\n{error}",
                                'labelOptions' => ['class' => '']
                            ])->textInput(['class' => 'form-control']) ?>
                        </div>

                        <div class="row">
                            <?php echo $form->field($model->clientsRequisitesModel, 'ogrn', [
                                'options' => ['class' => 'col-md-4 col-sm-4 col-xs-4 form-group'],
                                'template' => "{label}\n{input}\n{hint}\n{error}",
                                'labelOptions' => ['class' => '']
                            ])->textInput(['class' => 'form-control']) ?>

                            <?php echo $form->field($model->clientsRequisitesModel, 'inn', [
                                'options' => ['class' => 'col-md-4 col-sm-4 col-xs-4 form-group'],
                                'template' => "{label}\n{input}\n{hint}\n{error}",
                                'labelOptions' => ['class' => '']
                            ])->textInput(['class' => 'form-control']) ?>

                            <?php echo $form->field($model->clientsRequisitesModel, 'kpp', [
                                'options' => ['class' => 'col-md-4 col-sm-4 col-xs-4 form-group'],
                                'template' => "{label}\n{input}\n{hint}\n{error}",
                                'labelOptions' => ['class' => '']
                            ])->textInput(['class' => 'form-control']) ?>
                        </div>

                        <div class="row">
                            <?php echo $form->field($model->clientsRequisitesModel, 'okpo', [
                                'options' => ['class' => 'col-md-4 col-sm-4 col-xs-4 form-group'],
                                'template' => "{label}\n{input}\n{hint}\n{error}",
                                'labelOptions' => ['class' => '']
                            ])->textInput(['class' => 'form-control']) ?>

                            <?php echo $form->field($model->clientsRequisitesModel, 'ras', [
                                'options' => ['class' => 'col-md-4 col-sm-4 col-xs-4 form-group'],
                                'template' => "{label}\n{input}\n{hint}\n{error}",
                                'labelOptions' => ['class' => '']
                            ])->textInput(['class' => 'form-control']) ?>

                            <?php echo $form->field($model->clientsRequisitesModel, 'corr_account', [
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
                                    'label' => 'Юридический адрес'
                                ],
                                'optionsField' => [
                                    'template' => "{label}\n{input}\n{hint}\n{error}",
                                    'labelOptions' => ['class' => ''],
                                    'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group']
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-heading"><h3 class="panel-title">Дополнительно</h3></div>
                <div class="panel-body">
                    <?= $form->field($model, 'text')->textarea() ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->errorSummary($model) ?>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style type="text/css">
    .panel{
        border: 1px solid #aac1e4;
    }
    .panel .panel-heading{
        font-weight: bold;
        font-size: 14px;
    }
    .panel .panel-heading{
        border-bottom: 1px solid #b8d1f7;
        background-color: #c7dbff;
    }
</style>