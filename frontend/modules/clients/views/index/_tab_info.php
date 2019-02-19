<?php

use yii\helpers\Html;
use common\repositories\ClientsRepository;
use \common\components\detail\DetailView;
use \common\repositories\PhonesRepository;

/* @var $this yii\web\View */
/* @var $model common\repositories\ClientsRepository */

$labels = (new \common\repositories\ClientsRepository())->attributeLabels();
$attrRequisitesLabels = (new \common\repositories\ClientsRequisitesRepository())->attributeLabels();

?>

<?= DetailView::widget([
    'model' => $model,

    'attributes' => [
        [
            'subHeader' => true,
            'value' => ($isFiz ? 'Личные данные' : 'Основные данные') . ' (' . ClientsRepository::$types[$model['type']] . ')',
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
            'label' => $labels['sex'],
            'format' => 'raw',
            'value' => ClientsRepository::getSexName($model['sex']),
            'visible' => $isFiz
        ],
        [
            'label' => 'Телефон',
            'format' => 'raw',
            'value' => function($model) {
                $html = '';
                foreach ($model['phones'] as $item) {
                    $html .= "<span class='fa fa-phone' style='color: green'></span> " . PhonesRepository::phoneFormat($item['phone']) . "<br>";
                }
                return $html;
            }
        ],

        /** Паспортные данные */
        [
            'subHeader' => true,
            'value' => 'Паспортные данные',
            'captionOptions' => ['class' => 'text-center'],
            'rowOptions' => ['style' => 'background-color: #c7dbff;'],
            'visible' => $isFiz
        ],
        [
            'attribute' => 'address',
            'value' => htmlspecialchars($model['address']),
            'label' => 'Адрес',
            'visible' => $isFiz
        ],
        [
            'attribute' => 'passport_series',
            'label' => $labels['passport_series'],
            'visible' => $isFiz
        ],
        [
            'attribute' => 'passport_number',
            'label' => $labels['passport_number'],
            'visible' => $isFiz
        ],
        [
            'attribute' => 'passport_date',
            'format' => 'date',
            'label' => $labels['passport_date'],
            'visible' => $isFiz
        ],
        [
            'attribute' => 'passport_issue',
            'label' => $labels['passport_issue'],
            'visible' => $isFiz
        ],
        [
            'attribute' => 'birthday',
            'format' => 'date',
            'label' => $labels['birthday'],
            'visible' => $isFiz
        ],

        /** ----------Реквизиты----- */
        [
            'subHeader' => true,
            'value' => 'Реквизиты',
            'captionOptions' => ['class' => 'text-center'],
            'rowOptions' => ['style' => 'background-color: #c7dbff;'],
            'visible' => !$isFiz
        ],
        [
            'attribute' => 'bank',
            'label' => $attrRequisitesLabels['bank'],
            'visible' => !$isFiz
        ],
        [
            'attribute' => 'ogrn',
            'label' => $attrRequisitesLabels['ogrn'],
            'visible' => !$isFiz
        ],
        [
            'attribute' => 'inn',
            'label' => $attrRequisitesLabels['inn'],
            'visible' => !$isFiz
        ],
        [
            'attribute' => 'kpp',
            'label' => $attrRequisitesLabels['kpp'],
            'visible' => !$isFiz
        ],
        [
            'attribute' => 'okpo',
            'label' => $attrRequisitesLabels['okpo'],
            'visible' => !$isFiz
        ],
        [
            'attribute' => 'ras',
            'label' => $attrRequisitesLabels['ras'],
            'visible' => !$isFiz
        ],
        [
            'attribute' => 'corr_account',
            'label' => $attrRequisitesLabels['corr_account'],
            'visible' => !$isFiz
        ],
        [
            'value' => $model['address'],
            'label' => 'Юридический адрес',
            'visible' => !$isFiz
        ],


        /** ----------Общие--------- */
        [
            'subHeader' => true,
            'value' => 'Дополнительная информация',
            'captionOptions' => ['class' => 'text-center'],
            'rowOptions' => ['style' => 'background-color: #c7dbff;'],
        ],
        [
            'attribute' => 'managerName',
            'format' => 'raw',
            'value' => Html::a(
                htmlspecialchars($model['managerName'] ? : $model['username']),
                ['/user/default/view', 'id' => $model['user_id'] ], ['target' => '_blank']),
            'label' => 'Менеджер',
        ],
        [
            'attribute' => 'text',
            'value' => htmlspecialchars($model['text']),
            'label' => $labels['text'],
        ],
        [
            'label' => $labels['status'],
            'format' => 'raw',
            'value' => ClientsRepository::getStatusName($model['status']),
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
            'visible' => (($model['updated_at'] > 0) && ($model['updated_at'] != $model['created_at']))
        ],
    ],
]) ?>