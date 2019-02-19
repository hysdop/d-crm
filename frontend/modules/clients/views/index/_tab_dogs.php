<?php

use yii\helpers\Html;
use common\repositories\ClientsRepository;
use \common\components\detail\DetailView;
use \common\repositories\PhonesRepository;
use \common\repositories\MeasurementsRepository;
use common\components\Icons;
use common\repositories\DogsRepository;

/** @var $measurements array */

$labels = (new \common\repositories\DogsRepository())->attributeLabels();

?>

<?php foreach ($dogs as $item): ?>
    <?= DetailView::widget([
        'model' => $item,
        'attributes' => [
            [
                'subHeader' => true,
                'value' => 'Договор',
                'captionOptions' => ['class' => 'text-center'],
                'rowOptions' => ['style' => 'background-color: #c7dbff;']
            ],
            'name' => [
                'attribute' => 'firstname',
                'label' => $isFiz ? 'ФИО' : 'Наименование организации',
                'value' => function($data) {
                    return htmlspecialchars($data['firstname'] . ' ' . $data['lastname'] . ' ' . $data['middlename']);
                },
            ],
            [
                'label' => 'Телефон',
                'format' => 'raw',
                'value' => function($model) {
                    $html = '';
                    $phones = PhonesRepository::getPhones(PhonesRepository::TYPE_DOG, $model['id']);
                    foreach ($phones as $item) {
                        $html .= Icons::get(Icons::PHONE, 'green') . PhonesRepository::phoneFormat($item['phone']) . "<br>";
                    }
                    return $html;
                }
            ],
            [
                'label' => $labels['status'],
                'format' => 'raw',
                'value' => function($data) {
                    return DogsRepository::getStatusName($data['status']);
                }
            ],

            [
                'label' => $labels['sum'],
                'value' => function($data) {
                    return $data['sum'];
                }
            ],
            [
                'label' => $labels['discount'],
                'value' => function($data) {
                    return ($data['discount'] ? : 0) . ' %';
                }
            ],
            [
                'label' => '',
                'format' => 'raw',
                'value' => function($data) {
                    $html = '';
                    $html .= Html::a(Icons::get(Icons::MEASUREMENT) . ' Показать замер', ['/measurements/index/view', 'id' => $data['measurement_id']], ['class' => 'btn btn-primary']);
                    return $html;
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
                    return $data['managerName'];
                }
            ],
            [
                'label' => $labels['text'],
                'value' => function($data) {
                    return $data['text'];
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
        ]]); ?>
<?php endforeach; ?>