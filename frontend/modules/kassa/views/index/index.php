<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\repositories\DirectoriesRepository
;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\kassa\search\KassaInSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Касса';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kassa-in-repository-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Kassa In Repository', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'sum',
            [
                'attribute' => 'type_id',
                'value' => function($data){
                    return $data['typeName'];
                },
                'filter' => Html::activeDropDownList($searchModel, 'type_id', ArrayHelper::map(
                    DirectoriesRepository::getPossibleDirectories(DirectoriesRepository::TYPE_KASSA_IN),
                    'id', 'name'), ['class'=>'form-control', 'prompt' => ''])
            ],
            'status',
            'user_id',
            // 'employee_id',
            // 'dog_id',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
