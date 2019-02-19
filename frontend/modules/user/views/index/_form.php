<?php

use common\repositories\UserRepository;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\repositories\OfficeRepository;
use common\repositories\CompanyRepository;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\UserForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $permissions yii\rbac\Permission[] */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
        <?php echo $form->field($model, 'username') ?>

        <?php echo $form->field($model, 'email') ?>

        <?php echo $form->field($model, 'office_id')->dropDownList(
            [null] + ArrayHelper::map(CompanyRepository::getOffices(Yii::$app->user->identity->company_id, true), 'id', 'name'))
        ?>

        <?php echo $form->field($model, 'password')->passwordInput() ?>

        <?php echo $form->field($model, 'status')->dropDownList(UserRepository::statuses()) ?>

        <?php echo $form->field($model, 'roles')->checkboxList($roles)->label('Роли') ?>
        <div class="form-group">
            <?php echo Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
