<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use \common\repositories\CompanyRepository;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'Карта дилера';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['/settings/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="">

    <?php $form = ActiveForm::begin([
        'id' => 'company-form',
        'enableClientValidation' => false,
    ]); ?>
    <div class="x_panel">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Основные</a></li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Адрес</a></li>
                <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Контакты</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                    <?= $form->field($company, 'name')->textInput() ?>

                    <?= $form->field($company, 'type')->dropDownList(CompanyRepository::$TYPE_LIST) ?>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                    <p>
                        <?php echo \common\components\fias\FiasWidget::widget([
                                'model' => $company,
                                'addressModel' => $company->addressModel,
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
                    </p>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                    <?php echo $form->field($company, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
                        'mask' => '(999) 999-9999',
                        'clientOptions' => [
                            'removeMaskOnSubmit' => true,
                        ]
                    ]) ?>

                    <?php echo $form->field($company, 'phone_second')->widget(\yii\widgets\MaskedInput::className(), [
                        'mask' => '(999) 999-9999',
                        'clientOptions' => [
                            'removeMaskOnSubmit' => true,
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
        <br>
        <?php echo $form->errorSummary($company); ?>
        <button class="btn btn-success" type="submit">Сохранить</button>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<style type="text/css">
    .bar_tabs {
        padding-left: 0 !important;
    }
    .bar_tabs li:first-child{
        margin-left: 0 !important;
    }
</style>