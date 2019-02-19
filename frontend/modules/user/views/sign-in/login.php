<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\LoginForm */

$this->title = Yii::t('frontend', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>


<div>
    <a class="hiddenanchor" id="signin"></a>
    <a class="hiddenanchor" id="resetpass"></a>


    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                    <h1>Вход</h1>
                    <div>
                        <?php echo $form->field($model, 'identity')
                            ->textInput(['placeholder' => 'Логин', 'required'=>1])
                            ->label(false) ?>
                    </div>
                    <div>
                        <?php echo $form->field($model, 'password')
                            ->passwordInput(['placeholder' => 'Пароль', 'required'=>1])
                            ->label(false) ?>
                    </div>
                    <div>
                        <?php echo Html::submitButton(Yii::t('frontend', 'Вход'), ['class' => 'btn btn-default submit', 'name' => 'login-button']) ?>
                        <a class="reset_pass hide" href="#resetpass">Забыли пароль?</a>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <img src="/images/minilogo.png" style="margin-bottom: 5px;">
                            <p>© 2017 Berta</p>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </section>
        </div>

        <div class="animate form registration_form">
            <section class="login_content">
                <form>
                    <h1>Reset Account</h1>
                    <div>
                        <input type="text" class="form-control" placeholder="Username" required="" />
                    </div>
                    <div>
                        <input type="email" class="form-control" placeholder="Email" required="" />
                    </div>
                    <div>
                        <input type="password" class="form-control" placeholder="Password" required="" />
                    </div>
                    <div>
                        <a class="btn btn-default submit" href="index.html">Submit</a>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <p class="change_link">Already a member ?
                            <a href="#signin" class="to_register"> Log in </a>
                        </p>

                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                            <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>