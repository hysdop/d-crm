<?php

use yii\helpers\Html;
use common\repositories\ClientsRepository;
use \common\components\detail\DetailView;
use \common\repositories\PhonesRepository;
use \common\repositories\MeasurementsRepository;

/** @var $measurements array */

$labels = (new \common\repositories\ComingsRepository())->attributeLabels();

?>

<?php foreach ($comings as $item): ?>
    <?= DetailView::widget([
        'model' => $item,
        'attributes' => [
            [
                'subHeader' => true,
                'value' => 'Обращение #' .$item['id'],
                'captionOptions' => ['class' => 'text-center'],
                'rowOptions' => ['style' => 'background-color: #c7dbff;']
            ],
            'name' => [
                'attribute' => 'firstname',
                'label' => $isFiz ? 'ФИО' : 'Наименование организации',
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
                'label' => $labels['phone'],
                'format' => 'raw',
                'value' => function($data) {
                    $phones = PhonesRepository::getPhones(PhonesRepository::TYPE_COMING, $data['id']);
                    $html = '';
                    foreach ($phones as $item) {
                        $html .= \common\repositories\PhonesRepository::phoneFormat($item['phone'], true) . "<br>";
                    }
                    return $html;
                }
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
                'label' => $labels['expected_order_date'],
                'format' => 'raw',
                'value' => function($data) {
                    return Yii::$app->formatter->asDate($data['expected_order_date']);
                }
            ],
            [
                'label' => $labels['user_id'],
                'value' => function($data) {
                    return $data['userName'];
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
                'visible' => (($item['updated_at'] > 0) && ($item['updated_at'] != $item['created_at']))
            ],
            [
                'label' => '',
                'format' => 'raw',
                'value' => function($data) {
                    $html = '';
                    $html .= Html::a('Открыть', ['/comings/index/view', 'id' => $data['id']], ['class' => 'btn btn-primary']);
                    return $html;
                }
            ],
        ]]); ?>
<?php endforeach; ?>
