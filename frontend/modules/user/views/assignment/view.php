<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\YiiAsset;
use common\components\Icons;

/* @var $this yii\web\View */
/* @var $model frontend\modules\admin\models\Assignment */
/* @var $fullnameField string */

$userName = $model->{$usernameField};
if (!empty($fullnameField)) {
    $userName .= ' (' . ArrayHelper::getValue($model, $fullnameField) . ')';
}
$userName = Html::encode($userName);

$this->title = 'Правила доступа: ' . $userName;

$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['/settings/index']];
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['/user/index']];
$this->params['breadcrumbs'][] = $userName;

\frontend\modules\user\AnimateAsset::register($this);
YiiAsset::register($this);
$opts = Json::htmlEncode([
        'items' => $model->getItems()
    ]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>';
?>
<div class="assignment-index">
    <h1><?= $this->title ?></h1>

    <div class="row">
        <div class="col-sm-5">
            <h4>Доступные</h4>
            <input class="form-control search" data-target="avaliable"
                   placeholder="поиск">
            <select multiple size="20" class="form-control list" data-target="avaliable">
            </select>
        </div>
        <div class="col-sm-1">
            <br><br>
            <?= Html::a(Icons::get(Icons::RIGHT) . $animateIcon, ['assign', 'id' => (string)$model->id], [
                'class' => 'btn btn-success btn-assign',
                'data-target' => 'avaliable',
                'title' => 'Привязать'
            ]) ?><br><br>
            <?= Html::a(Icons::get(Icons::LEFT) . $animateIcon, ['revoke', 'id' => (string)$model->id], [
                'class' => 'btn btn-danger btn-assign',
                'data-target' => 'assigned',
                'title' => 'Убрать'
            ]) ?>
        </div>
        <div class="col-sm-5">
            <h4>Привязанные</h4>
            <input class="form-control search" data-target="assigned"
                   placeholder="поиск">
            <select multiple size="20" class="form-control list" data-target="assigned">
            </select>
        </div>
    </div>
</div>
