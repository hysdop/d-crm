<?php

use yii\helpers\Html;
use common\components\detail\DetailView;
use  \common\repositories\MeasurementsRepository;
use common\components\Icons;
use \yii\bootstrap\BaseHtml;

/* @var $this yii\web\View */
/* @var $model common\repositories\MeasurementsRepository */

$this->title = 'Замеры сотрудника';
$this->params['breadcrumbs'][] = ['label' => 'Замеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Календарь замеров', 'url' => ['/measurements/calendar']];
$this->params['breadcrumbs'][] = $this->title;

$labels = (new MeasurementsRepository())->attributeLabels();
?>
<div class="measurements-repository-view">
    <h1>Замеры сотрудника</h1>
    <table class="table">
        <caption><?= Icons::get(Icons::USER) ?> Сотрудник: <?= BaseHtml::a(
                htmlspecialchars(trim($user['employeeName']) ? : $user['username']), [
                    '/user/default/view',
                    'id' => $user['id']
                ]) ?>,  <?= Yii::$app->formatter->asDate($date) ?>
        </caption>
        <thead>
            <tr>
                <th width="5">#</th>
                <th><?= Icons::get(Icons::TIMER) ?> Время</th>
                <th>Статус</th>
                <th>Адрес</th>
                <th width="30"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($measurements as $i => $item): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= Yii::$app->formatter->asTime($item['time']) ?></td>
                    <td><?= MeasurementsRepository::getStatusNameWithIcon($item['status']) ?></td>
                    <td><?= htmlspecialchars($item['address']) ?></td>
                    <td><?= BaseHtml::a(Icons::get(Icons::MEASUREMENT) . ' открыть', ['/measurements/index/view', 'id' => $item['id']], ['class' => 'btn btn-default btn-xs']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style type="text/css">

    .table tr td:first-child a{
        color: #dbffe0;
        font-weight: bold;
    }

    .table {
        border: 1px solid #00a157;
        color: #FFF;
        background-color: #2A3F54;
    }

    .table tr td{
        border-right: 1px solid #ffffff;
        border-bottom: 1px solid #18384d;
    }

    .table tr th{
        text-align: center;
        background-color: #264e70;
        border-right: 1px solid #ffffff;
    }
</style>