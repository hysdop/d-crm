<?php

use yii\helpers\Html;
use common\components\detail\DetailView;
use \common\repositories\ClientsRepository;
use \common\repositories\PhonesRepository;
use \common\repositories\CompanyRepository;

/* @var $this yii\web\View */
/* @var $model common\repositories\CompanyRepository */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Дилеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$labels = (new \common\repositories\ClientsRepository())->attributeLabels();

$usersInfo = CompanyRepository::getEmployeesInfo($model['id']);

?>
<div class="company-repository-view">

    <p>
        <?php echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'phone',
                'format' => 'raw',
                'value' => PhonesRepository::phoneFormat($model['phone'], true)
            ],
            [
                'attribute' => 'phone_second',
                'format' => 'raw',
                'value' => PhonesRepository::phoneFormat($model['phone_second'], true)
            ],
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => CompanyRepository::getTypeName($model['type'], true)
            ],
            [
                'label' => $labels['status'],
                'format' => 'raw',
                'value' => ClientsRepository::getStatusName($model['status']),
            ],
            [
                'subHeader' => true,
                'value' => 'Дополнительно',
                'captionOptions' => ['class' => 'text-center'],
                'rowOptions' => ['style' => 'background-color: #c7dbff;'],
            ],
            [
                'format' => 'raw',
                'label' => 'Сотрудников',
                'value' => $usersInfo['count']
            ],
            [
                'format' => 'raw',
                'label' => 'Активных',
                'value' => $usersInfo['active']
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'label' => $labels['created_at'],
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'datetime',
                'label' => $labels['updated_at'],
                'visible' => (($model['updated_at'] > 0) && ($model['updated_at'] != $model['created_at'])) ? true : false
            ],
        ],
    ]) ?>

</div>
