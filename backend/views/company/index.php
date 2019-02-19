<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \common\repositories\CompanyRepository;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дилеры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-repository-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a('Добавить дилера', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            [
                'attribute' => 'phone',
                'format' => 'raw',
                'value' => function($data) {
                    $html = $data['phone'] ? "<span class='fa fa-phone' style='color: green'></span> " . $data['phone'] : '';
                    $html .= $data['phone_second'] ? "<br><span class='fa fa-phone' style='color: green'></span> " . $data['phone_second'] : '';
                    return $html;
                },
                'filter' => Html::activeTextInput($searchModel, 'filterPhone',
                    ['class'=>'form-control', 'prompt' => ''])
            ],
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function($data) {
                    return CompanyRepository::getTypeName($data['type']);
                },
                'filter' => Html::activeDropDownList($searchModel, 'type', CompanyRepository::$TYPE_LIST,
                    ['class'=>'form-control', 'prompt' => ''])
            ],
            // 'address_id',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
