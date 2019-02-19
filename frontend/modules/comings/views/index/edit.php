<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \unclead\multipleinput\TabularInput;
use \yii\helpers\BaseHtml;
use \common\repositories\DirectoriesRepository;
use \yii\helpers\ArrayHelper;
use \dosamigos\datetimepicker\DateTimePicker;
use \common\repositories\ComingsRepository;
use \yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'Новое обращение';
$this->params['breadcrumbs'][] = ['label' => 'Обращения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel hide">
            <div class="x_title">
                <h3 class="hide" style="margin-bottom: 0;">Новое обращение <small></small></h3>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

            </div>
        </div>

        <h3 class="" style="margin-bottom: 0;">Новое обращение <small></small></h3>
        <br>

                <?php $form = ActiveForm::begin([
                    'id' => 'coming-form',
                    'enableClientValidation' => false,
                    'options' => ['class' => 'form-horizontal form-label-left'
                ]]); ?>

                <?php \yii\jui\AutoComplete::widget([
                    'name' => 'phone',
                    'model' => $model,
                    //'attribute' => 'name',
                    'options' => ['placeholder' => '', 'class' => 'form-control'],
                    'clientOptions' => [
                        'serviceUrl' => Url::to(['/comings/ajax/clients-by-phone']),
                        'autoFill' => true,
                        'dataType' => 'json',
                        //'paramName' => 'phone',
                        //'minLength' => '0',
                        'transformResult' => new JsExpression('function (response) {
                                return {
                                    suggestions: $.map(response, function (value, key) {
                                        return { value: value.phone};
                                    })
                                };
                            }
                        '),
                        'select' => new JsExpression('function( event, ui ) {
                        // $( "#Sborka" ).val( ui.item.name + " / " + ui.item.blok_num );
                    return false;}'),
                    ],
                ]); ?><br>

                <div class="row row-eq-height">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="panel">
                            <div class="panel-heading">Клиент</div>
                            <div class="panel-body">
                                <div class="row">
                                    <?php echo $form->field($model, 'type_id', [
                                        'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12'],
                                        'template' => "{label}\n{input}\n{hint}\n{error}",
                                        'labelOptions' => ['class' => '']
                                    ])->widget(\common\components\autoradio\AutoRadioWidget::className(), [
                                        'form' => $form,
                                        'options' => ['label' => false],
                                        'selectAfter' => 1,
                                        'nullOption' => true,
                                        'items' => ArrayHelper::map(DirectoriesRepository::getPossibleDirectories(DirectoriesRepository::TYPE_COMING_NATURE),'id','name')
                                    ]) ?>

                                    <?php echo $form->field($model, 'lastname', [
                                        'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group'],
                                        'template' => "{label}\n{input}\n{hint}\n{error}",
                                        'labelOptions' => ['class' => '']
                                    ])->textInput(['class' => 'form-control col-md-4 col-xs-12']) ?>

                                    <?php echo $form->field($model, 'firstname', [
                                        'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group'],
                                        'template' => "{label}\n{input}\n{hint}\n{error}",
                                        'labelOptions' => ['class' => '']
                                    ])->textInput(['class' => 'form-control col-md-4 col-xs-12']) ?>

                                    <?php echo $form->field($model, 'middlename', [
                                        'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group'],
                                        'template' => "{label}\n{input}\n{hint}\n{error}",
                                        'labelOptions' => ['class' => '']
                                    ])->textInput(['class' => 'form-control col-md-4 col-xs-12']) ?>


                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-success">
                                            <label>Телефон</label>
                                            <div class=" ">
                                                <?= TabularInput::widget([
                                                    'form' => $form,
                                                    'max' => 4,
                                                    'models' => $model->phonesItems,
                                                    'attributeOptions' => [
                                                        //'enableAjaxValidation'      => true,
                                                        'enableClientValidation'    => false,
                                                        //'validateOnChange'          => false,
                                                        // 'validateOnSubmit'          => true,
                                                        //'validateOnBlur'            => false,
                                                    ],
                                                    'columns' => [
                                                        [
                                                            'name' => 'phone',
                                                            'type' => \yii\widgets\MaskedInput::class,
                                                            'options' => [
                                                                'mask' => '(999) 999-9999',
                                                                'clientOptions' => [
                                                                    'removeMaskOnSubmit' => true,
                                                                ],
                                                                'options' => [
                                                                    'class' => 'form-control'
                                                                ]
                                                            ],
                                                            'attributeOptions' => [

                                                            ],
                                                            'enableError' => true
                                                        ],
                                                    ],
                                                ]) ?>
                                            </div>
                                            <div class="has-error">
                                                <div class="help-block"><?php echo BaseHtml::error($model, 'phonesItems') ?></div>
                                            </div>
                                    </div>

                                    <?php echo \common\components\fias\FiasWidget::widget([
                                        'model' => $model,
                                        'form' => $form,
                                        'addressModel' => $model->addressModel,
                                        'attribute' => 'addressText',
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

                                <div class="row">
                                    <?php echo $form->field($model, 'birthday', [
                                        'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group'],
                                        'template' => "{label}\n{input}\n{hint}\n{error}",
                                        'labelOptions' => ['class' => '']
                                    ])->widget(\yii\jui\DatePicker::classname(), [
                                        'options' => ['class' => 'form-control'],
                                        'language' => 'ru',
                                        'dateFormat' => 'yyyy-MM-dd',
                                    ]) ?>

                                    <?php echo $form->field($model, 'sex', [
                                        'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12'],
                                        'template' => "{label}\n{input}\n{hint}\n{error}",
                                        'labelOptions' => ['class' => '']
                                    ])->widget(\common\components\autoradio\AutoRadioWidget::className(), [
                                        'form' => $form,
                                        'options' => ['label' => false],
                                        'selectAfter' => 1,
                                        'items' => ComingsRepository::$sexList
                                    ]) ?>

                                    <?php echo $form->field($model, 'source_id', [
                                        'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12'],
                                        'template' => "{label}\n{input}\n{hint}\n{error}",
                                        'labelOptions' => ['class' => '']
                                    ])->widget(\common\components\autoradio\AutoRadioWidget::className(), [
                                        'form' => $form,
                                        'options' => ['label' => false],
                                        'selectAfter' => 1,
                                        'items' => ArrayHelper::map(DirectoriesRepository::getPossibleDirectories(DirectoriesRepository::TYPE_COMING_SOURCE),'id','name')
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="panel">
                            <div class="panel-heading">Действие</div>
                            <div class="panel-body">
                                <?php echo $form->field($model, 'expected_action_id', [
                                    'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group'],
                                    'template' => "{label}\n{input}\n{hint}\n{error}",
                                    'labelOptions' => ['class' => '']
                                ])->widget(\common\components\autoradio\AutoRadioWidget::className(), [
                                    'form' => $form,
                                    'options' => ['label' => false],
                                    'selectAfter' => 3,
                                    'items' => ArrayHelper::map(DirectoriesRepository::getPossibleDirectories(DirectoriesRepository::TYPE_COMING_ACTION),'id','name')
                                ]) ?>

                                <?php echo $form->field($model, 'expected_action_date', [
                                    'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group'],
                                    'template' => "{label}\n{input}\n{hint}\n{error}",
                                    'labelOptions' => ['class' => '']
                                ])->widget(DateTimePicker::className(), [
                                    'options' => ['class' => 'form-control'],
                                    'language' => 'ru',
                                ]) ?>
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-heading">Заказ</div>
                            <div class="panel-body">
                                <?php echo $form->field($model, 'constructions', [
                                    'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group'],
                                    'template' => "{label}\n{input}\n{hint}\n{error}",
                                    'labelOptions' => ['class' => '']
                                ])->textInput(['class' => 'form-control col-md-7 col-xs-12']) ?>

                                <?php echo $form->field($model, 'expected_order_date', [
                                    'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group'],
                                    'template' => "{label}\n{input}\n{hint}\n{error}",
                                    'labelOptions' => ['class' => '']
                                ])->widget(\yii\jui\DatePicker::classname(), [
                                    'options' => ['class' => 'form-control'],
                                    'language' => 'ru',
                                    'dateFormat' => 'yyyy-MM-dd',
                                ]) ?>

                                <?php echo $form->field($model, 'buy_forecast_id', [
                                    'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12'],
                                    'template' => "{label}\n{input}\n{hint}\n{error}",
                                    'labelOptions' => ['class' => '']
                                ])->widget(\common\components\autoradio\AutoRadioWidget::className(), [
                                    'form' => $form,
                                    'options' => ['label' => false],
                                    'selectAfter' => 3,
                                    'nullOption' => true,
                                    'items' => ArrayHelper::map(DirectoriesRepository::getPossibleDirectories(DirectoriesRepository::TYPE_COMING_BUY_FORECAST), 'id', 'name')
                                ]) ?>

                                <?php echo $form->field($model, 'comment_user', [
                                    'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group'],
                                    'template' => "{label}\n{input}\n{hint}\n{error}",
                                    'labelOptions' => ['class' => '']
                                ])->textarea(['class' => 'form-control col-md-7 col-xs-12', 'rows' => 3]) ?>

                                <?php echo $form->field($model, 'comment_client', [
                                    'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group'],
                                    'template' => "{label}\n{input}\n{hint}\n{error}",
                                    'labelOptions' => ['class' => '']
                                ])->textarea(['class' => 'form-control col-md-7 col-xs-12', 'rows' => 3]) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div><br>

                <?php //echo $form->errorSummary($model); ?>

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <button type="submit" name="<?= BaseHtml::getInputName($model, 'measurementBtn') ?>" value="1" class="btn btn-primary pull-right">Создать замер</button>

                            <button type="submit" class="btn btn-success pull-right">Сохранить</button>
                        </div>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

