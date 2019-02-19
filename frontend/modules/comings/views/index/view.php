<?php

use yii\helpers\Html;
use common\components\detail\DetailView;
use common\components\Icons;

/* @var $this yii\web\View */
/* @var $model common\repositories\ComingsRepository */

$this->title = htmlspecialchars($model['firstname'] . ' ' . $model['lastname']);
$this->params['breadcrumbs'][] = ['label' => 'Обращения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$isFiz = 1;
?>
<div class="comings-repository-view">
    <div class="pull-right">
        <?= Html::a('<span class="fa fa-crop"></span> Создать замер', ['/measurements/calendar', 'id' => $model['id'],
            'type' => \common\repositories\MeasurementsRepository::FROM_COMING],
            [
                'class' => 'btn btn-primary',
                'title' => 'Создать замер'
            ]) ?>
        <?= Html::a('<span class="fa fa-pencil"></span> Изменить', ['update', 'id' => $model['id']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="fa fa-trash"></span> Удалить', ['delete', 'id' => $model['id']], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить клиента?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="clearfix"></div>
    <div class="" role="tabpanel" data-example-id="togglable-tabs">
        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
            <li role="presentation" class="active"><a href="#tab-comings" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><?= Icons::get(Icons::COMING) ?> Обращение</a></li>
            <li role="presentation" class=""><a href="#tab-measurements" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><?= Icons::get(Icons::MEASUREMENT) ?> Замеры</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab-comings" aria-labelledby="profile-tab">
                <p><?php echo $this->render('_tab_coming', ['model' => $model, 'coming' => $model, 'isFiz' => $isFiz]) ?></p>
            </div>
            <div role="tabpanel" class="tab-pane   fade" id="tab-measurements" aria-labelledby="profile-tab">
                <?php echo $this->render('_tab_measurements', [
                    'model' => $model,
                    'measurements' => $measurements,
                    'isFiz' => $isFiz
                ]) ?>
            </div>
        </div>
    </div>
</div>