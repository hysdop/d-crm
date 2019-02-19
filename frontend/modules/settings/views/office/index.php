<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \common\repositories\PhonesRepository;
use \common\repositories\OfficeRepository;
use common\components\Icons;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\settings\search\OfficeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Офисы';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['/settings/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-repository-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'phone',
                'format' => 'raw',
                'value' => function($data) {
                    $html = '';
                    if ($data['phone']) {
                        $html .= PhonesRepository::phoneFormat($data['phone'], true) . '<br>';
                    }
                    if ($data['phone_second']) {
                        $html .= PhonesRepository::phoneFormat($data['phone_second'], true) . '<br>';
                    }
                    return $html;
                },
                'filter' => \yii\widgets\MaskedInput::widget([
                    'model' => $searchModel,
                    'name' => 'OfficeSearch[phone]',
                    'mask' => '(999) 999-9999',
                    'value' => htmlspecialchars($searchModel->phone)
                ])
            ],
            [
                'attribute' => 'type',
                'value' => function($data) {
                    return OfficeRepository::getTypeName($data['type']);
                },
                'filter' => Html::activeDropDownList($searchModel, 'type',
                    array_merge([null => ''], OfficeRepository::$types), ['class' => 'form-control'])
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'<div class="btn-group" role="group">{view}{update}{delete}</div>',
                'buttons'=> [
                    'update' => function ($url, $model, $key) {
                        return Html::a(Icons::get(Icons::EDIT), ['update', 'id' => $key], [
                            'title' => Yii::t('app', 'Редактировать'),
                            'class' => 'btn btn-primary btn-xs'
                        ]);
                    },
                    'view' => function ($url, $model, $key) {
                        return "<a title='Открыть' href='" . \yii\helpers\Url::to(['view', 'id'=>$key]) . "' target='_blank' class='btn btn-xs btn-primary'>" . Icons::get(Icons::OPEN) . " открыть</a>";
                    },
                    'delete' => function ($url, $model, $key) {
                        return "<a title='Удалить' href='" . \yii\helpers\Url::to(['delete', 'id'=>$key]) . "' 
                            title='Удалить' data-pjax='0' data-confirm='Вы уверены, что хотите удалить этот элемент?' 
                            data-method='post' class='btn btn-danger btn-xs'>" . Icons::get(Icons::DELETE) . "</a>";
                    },
                ],
            ],
        ],
    ]); ?>
</div>
