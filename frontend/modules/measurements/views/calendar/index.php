<?php

use \common\repositories\MeasurementsRepository;
use \yii\helpers\Url;
use common\components\Icons;
use \yii\helpers\Html;

$this->title = 'Календарь замеров';
$this->params['breadcrumbs'][] = ['label' => 'Замеры', 'url' => ['/measurements/index']];
$this->params['breadcrumbs'][] = $this->title;

$today = date('Y-m-d');
?>

<div class="row">
    <div class="col-lg-12">
        <h1><?php echo htmlspecialchars($this->title) ?></h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="input-group">
                    <span class="input-group-addon" ><?= Html::a(Icons::get(Icons::CALENDAR)) ?> Дата </span>
                        <?php echo \yii\jui\DatePicker::widget([
                            'options' => ['class' => 'form-control'],
                            'value' => $filter['date'],
                            'dateFormat' => 'yyyy-MM-dd',
                            'clientOptions' => [
                                'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { 
                                    location = "' . Url::to(['index',
                                        'z' => 1, // для добавления знака '?'
                                        'id' => $filter['fromId'],
                                        'type' => $filter['fromType']]) . '&date=" + dateText;
                                 }'),
                            ],
                        ]); ?>
                    <a title="Преведущая неделя" class="btn btn-default input-group-addon" href="<?= Url::to([
                        'index',
                        'date' => $filter['leftDate'],
                        'id' => $filter['fromId'],
                        'type' => $filter['fromType']
                    ]) ?>"><?= Icons::get(Icons::LEFT) ?></a>
                    <a title="Следующая неделя" class="btn btn-default input-group-addon" href="<?= Url::to([
                        'index',
                        'date' => $filter['rightDate'],
                        'id' => $filter['fromId'],
                        'type' => $filter['fromType']
                    ]) ?>"><?= Icons::get(Icons::RIGHT) ?></a>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>
    </div>
    <div class="col-lg-3"></div>
</div>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-calendar">
            <caption><?php if ($fromId && $fromType): ?><b>Выберите дату проведения замера:</b><?php endif;?> </caption>
    <tr>
        <th><?= Icons::get(Icons::USER) ?> Сотрудник / <?= Icons::get(Icons::CALENDAR) ?> Дата</th>
        <?php foreach ($days as $day): ?>
            <th><?php if ($day['day'] == $today) echo '<span style="color: lime">*</span>' ?> <?= $day['dayFormatted'] ?></th>
        <?php endforeach; ?>
    </tr>
    <?php foreach ($users as $userId => $item): ?>
        <tr>
            <td><?= Html::a(htmlspecialchars($item['user']['name']), ['/user/default/view', 'id' => $userId], ['target' => '_blank']) ?></td>
            <?php foreach ($days as $day): ?>
                <td class="date-cell" onclick="<?php if ($fromId && $fromType): ?>redirectCreateMeasurement(
                        <?= $userId ?>, <?= intval($fromType) ?>,  <?= intval($fromId)?>, '<?= $day['day'] ?>');
                    <?php else: ?>
                        openUserMeasurements(<?= intval($userId) ?>, '<?= $day['day'] ?>');
                <?php endif; ?>">
                    <?php if (array_key_exists($day['day'], $item['measurements'])): ?>
                        <?php foreach ($item['measurements'][$day['day']] as $mst): ?>
                            <?= $mst['time'] ?> - <?= MeasurementsRepository::getStatusNameWithIcon($mst['status']) ?><br>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>
    </div>
</div>

<script type="text/javascript">
    function redirectCreateMeasurement(uid, type, objid, date) {
        var a = date.split('-');
        var wDate = new Date (a[0], a[1]-1, a[2]);
        var today = new Date();
        if (wDate > today) {
            window.location = '/measurements/index/create?uid=' + uid + '&type=' + type + '&id=' + objid  + '&date=' + date;
        } else {
            alert("Недопустимая дата");
        }
    }

    function openUserMeasurements(uid, date) {
        window.location = '/measurements/calendar/user?uid=' + uid + '&date=' + date;
    }
</script>

<style type="text/css">
    .date-cell{
        cursor: pointer;
    }
    .date-cell:hover{
        background-color: #476b91;
    }

    .table tr:hover td:first-child {
        color: white;
        border-left: 5px solid #1ABB9C;
    }

    .table tr:hover td:first-child a{
        color: white;
    }
    .table tr td:first-child a{
        color: #dbffe0;
        font-weight: bold;
    }

    .table-calendar{
        border: 1px solid #00a157;
        color: #FFF;
        background-color: #2A3F54;
    }

    .table-calendar tr td{
        border-right: 1px solid #ffffff;
        border-bottom: 1px solid #18384d;
    }

    .table-calendar tr th{
        text-align: center;
        background-color: #264e70;
        border-right: 1px solid #ffffff;
    }
</style>