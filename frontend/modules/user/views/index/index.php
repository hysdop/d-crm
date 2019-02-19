<?php

use common\grid\EnumColumn;
use common\repositories\UserRepository;
use yii\helpers\Html;
use yii\grid\GridView;
use \common\components\Icons;
use yii\helpers\ArrayHelper;
use common\repositories\CompanyRepository;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Сотрудники');
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['/settings/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Добавить пользователя', [
    'modelClass' => 'User',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'columns' => [
            'id',
            [
                'attribute' => 'username',
                'label' => 'Логин',
                'format' => 'raw',
                'value' => function($data) {
                    return \yii\helpers\BaseHtml::a($data['username'], ['/user/default/view', 'id' => $data['id']]);
                }
            ],
            [
                'label' => 'ФИО',
                'attribute' => 'name',
                'value' => function($model) {
                    return htmlspecialchars($model['name']);
                },
                'filter' => Html::activeTextInput($searchModel, 'name', ['class' => 'form-control'])
            ],
            'email:email',
            [
                'class' => EnumColumn::className(),
                'attribute' => 'status',
                'enum' => UserRepository::statuses(),
                'filter' => UserRepository::statuses()
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'options' => ['class' => 'form-control'],
                    'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd'
                ])
            ],
            [
                'attribute' => 'logged_at',
                'format' => 'datetime',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'logged_at',
                    'options' => ['class' => 'form-control'],
                    'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd'
                ])
            ],
            [
                'attribute' => 'office_id',
                'label' => 'Офис',
                'value' => function($data) {
                    return htmlspecialchars($data['office']);
                },
                'filter' => Html::activeDropDownList($searchModel, 'office_id', ArrayHelper::map(
                    CompanyRepository::getOffices(Yii::$app->user->identity->company_id, true),
                    'id', 'name'), ['class'=>'form-control', 'prompt' => ''])
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '<div class="btn-group" style="width: 205px" role="group">{view}{rols}{update}{block}{delete}</div>',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return "<a title='Открыть' href='" . \yii\helpers\Url::to(['/user/default/view', 'id'=>$key]) . "' target='_blank' class='btn btn-xs btn-primary'><span class='glyphicon glyphicon-eye-open'></span> открыть</a>";
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $key], [
                            'title' => 'Редактировать',
                            'class' => 'btn btn-primary btn-xs'
                        ]);
                    },
                    'rols' => function ($url, $model, $key) {
                        return Html::a(Icons::get(Icons::LISTS) . ' права', ['/user/assignment/view', 'id' => $key], [
                            'title' => 'Права доступа',
                            'class' => 'btn btn-primary btn-xs'
                        ]);
                    },
                    'block' => function ($url, $model, $key) {
                        if (in_array($model['status'],  [UserRepository::STATUS_ACTIVE])) {
                            return Html::a('<span class="glyphicon glyphicon-off"></span>', ['block', 'id' => $key], [
                                'title' => 'Заблокрировать доступ?',
                                'data-pjax',
                                'data-confirm' => 'Вы уверены, что хотите заблокировать доступ пользователю?',
                                'data-method' => 'post',
                                'class' => 'btn btn-warning btn-xs'
                            ]);
                        } elseif (in_array($model['status'],  [UserRepository::STATUS_NOT_ACTIVE, UserRepository::STATUS_DELETED])) {
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', ['unblock', 'id' => $key], [
                                'title' => 'Активировать доступ?',
                                'data-pjax',
                                'data-confirm' => 'Вы уверены, что хотите разрешить доступ пользователю?',
                                'data-method' => 'post',
                                'class' => 'btn btn-success btn-xs'
                            ]);
                        }
                        return null;
                    },
                    'delete' => function ($url, $model, $key) {
                        return "<a title='Удалить' href='" . \yii\helpers\Url::to(['delete', 'id'=>$key]) . "' 
                            title='Удалить' data-pjax='0' data-confirm='Вы уверены, что хотите удалить этот элемент?' 
                            data-method='post' class='btn btn-danger btn-xs'>
                            <span class='glyphicon glyphicon-trash'></span></a>";
                    },
                ],
            ],
        ],
    ]); ?>

</div>
