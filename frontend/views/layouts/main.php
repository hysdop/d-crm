<?php

use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/base.php')
?>

<div class="container body">
    <div class="main_container">
        <?= \frontend\blocks\sidebar\SidebarBlock::widget() ?>

        <!-- top navigation -->
        <?= \frontend\blocks\topnav\TopNavBlock::widget(); ?>
        <!-- /top navigation -->

        <div class="right_col" role="main">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>

            <?php if (Yii::$app->session->hasFlash('alert')): ?>
                <?php \yii\bootstrap\Alert::widget([
                    'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
                    'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
                ]) ?>
            <?php endif; ?>

            <?= $content ?>
        </div>
    </div>
</div>
<?php $this->endContent() ?>
