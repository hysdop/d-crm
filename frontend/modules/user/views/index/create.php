<?php
/* @var $this yii\web\View */
/* @var $model backend\models\UserForm */
/* @var $roles yii\rbac\Role[] */
$this->title = Yii::t('backend', 'Добавить сотрудника', [
    'modelClass' => 'User',
]);
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['/settings/index']];
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['/user/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'roles' => $roles
    ]) ?>

</div>
