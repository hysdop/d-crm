<?php

use yii\helpers\Html;
use common\components\detail\DetailView;

$labels = (new \common\repositories\ComingsRepository())->attributeLabels();

?>

<?= DetailView::widget([
    'model' => $coming,
    'attributes' => [
        [
            'subHeader' => true,
            'value' => 'Личные данные',
            'captionOptions' => ['class' => 'text-center'],
            'rowOptions' => ['style' => 'background-color: #c7dbff;']
        ],
        'name' => [
            'attribute' => 'firstname',
            'label' => 'ФИО',
            'value' => function($data) {
                return htmlspecialchars($data['firstname'] . ' ' . $data['lastname'] . ' ' . $data['middlename']);
            }
        ],
        [
            'label' => 'Адрес',
            'value' => function($data) {
                return $data['address'];
            }
        ],
        [
            'label' => $labels['birthday'],
            'format' => 'raw',
            'value' => function($data) {
                return Yii::$app->formatter->asDate($data['birthday']);
            }
        ],
        [
            'label' => $labels['sex'],
            'value' => function($data) {
                return $data['sex'] ? 'Жен.' : 'Муж.';
            }
        ],
        [
            'label' => $labels['phone'],
            'format' => 'raw',
            'value' => function($data) {
                $html = '';
                foreach ($data['phones'] as $item) {
                    $html .= \common\repositories\PhonesRepository::phoneFormat($item['phone'], true) . "<br>";
                }
                return $html;
            }
        ],

        [
            'subHeader' => true,
            'value' => 'Обращение',
            'captionOptions' => ['class' => 'text-center'],
            'rowOptions' => ['style' => 'background-color: #c7dbff;']
        ],
        [
            'label' => 'Тип обращения',
            'value' => function($data) {
                return $data['typeName'];
            }
        ],
        [
            'label' => $labels['source_id'],
            'value' => function($data) {
                return $data['sourceName'];
            }
        ],
        [
            'label' => $labels['expected_action_id'],
            'value' => function($data) {
                return $data['actionName'];
            }
        ],
        [
            'label' => $labels['expected_action_date'],
            'format' => 'raw',
            'value' => function($data) {
                return Yii::$app->formatter->asDate($data['expected_action_date']);
            }
        ],
        [
            'label' => $labels['constructions'],
            'value' => function($data) {
                return $data['constructions'];
            }
        ],
        [
            'label' => $labels['expected_order_date'],
            'format' => 'raw',
            'value' => function($data) {
                return Yii::$app->formatter->asDate($data['expected_order_date']);
            }
        ],
        [
            'label' => 'Тип клиента',
            'value' => function($data) {
                return $data['forecastName'];
            }
        ],

        [
            'subHeader' => true,
            'value' => 'Дополнительная информация',
            'captionOptions' => ['class' => 'text-center'],
            'rowOptions' => ['style' => 'background-color: #c7dbff;']
        ],
        [
            'label' => $labels['user_id'],
            'value' => function($data) {
                return $data['userName'];
            }
        ],
        [
            'label' => $labels['comment_user'],
            'value' => function($data) {
                return htmlspecialchars($data['comment_user']);
            }
        ],
        [
            'label' => $labels['comment_client'],
            'value' => function($data) {
                return htmlspecialchars($data['comment_client']);
            }
        ],
        [
            'label' => $labels['status'],
            'value' => function($data) {
                return \common\repositories\ComingsRepository::getStatusName($data['status']);
            }
        ],
        [
            'label' => $labels['created_at'],
            'value' => function($data) {
                return Yii::$app->formatter->asDatetime($data['created_at']);
            }
        ],
        [
            'label' => $labels['updated_at'],
            'value' => function($data) {
                return Yii::$app->formatter->asDatetime($data['updated_at']);
            },
            'visible' => (($model['updated_at'] > 0) && ($model['updated_at'] != $model['created_at']))
        ],
    ],
]) ?>
