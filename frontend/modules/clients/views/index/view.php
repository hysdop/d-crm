<?php

use yii\helpers\Html;
use common\repositories\ClientsRepository;
use \common\components\detail\DetailView;
use \common\repositories\PhonesRepository;
use \common\components\Icons;

/* @var $this yii\web\View */
/* @var $model common\repositories\ClientsRepository */

$this->title = htmlspecialchars($model['firstname'] . ' ' . $model['lastname']);
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$labels = (new \common\repositories\ClientsRepository())->attributeLabels();
$attrRequisitesLabels = (new \common\repositories\ClientsRequisitesRepository())->attributeLabels();

$isFiz = ($model['type'] == \frontend\modules\clients\forms\ClientForm::TYPE_FIZ);

?>
<div class="clients-repository-view">
    <div class="pull-right">
        <?= Html::a(Icons::get(Icons::MEASUREMENT) . ' Создать замер', ['/measurements/calendar', 'id' => $model['id'],
            'type' => \common\repositories\MeasurementsRepository::FROM_CLIENT],
            [
                'class' => 'btn btn-primary',
                'title' => 'Создать замер'
            ]) ?>
        <?= Html::a(Icons::get(Icons::COMING) . ' Создать обращение', ['/comings/index/create', 'clientId' => $model['id'],
            ],
            [
                'class' => 'btn btn-primary',
                'title' => 'Создать обращение'
            ]) ?>
        <?= Html::a(Icons::get(Icons::EDIT) . ' Изменить', ['update', 'id' => $model['id']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Icons::get(Icons::DELETE) . ' ', ['delete', 'id' => $model['id']], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить клиента?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <h1>Клиент:  <?= Html::encode($model['firstname'] . ' ' . $model['lastname']) ?></h1>
    <div class="clearfix"></div>
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab-info" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false"><?= Icons::get(Icons::CLIENT) ?> Информация о клиенте</a></li>
                <li role="presentation" class=""><a href="#tab-comings" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><?= Icons::get(Icons::COMING) ?> Обращения</a></li>
                <li role="presentation" class=""><a href="#tab-measurements" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><?= Icons::get(Icons::MEASUREMENT) ?> Замеры</a></li>
                <li role="presentation" class=""><a href="#tab-dogs" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><?= Icons::get(Icons::DOG) ?> Договора</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab-info" aria-labelledby="home-tab">
                    <p><?php echo $this->render('_tab_info', ['model' => $model, 'isFiz' => $isFiz]) ?></p>
                </div>
                <div role="tabpanel" class="tab-pane fade " id="tab-comings" aria-labelledby="profile-tab">
                    <p><?php echo $this->render('_tab_comings', ['model' => $model, 'comings' => $comings, 'isFiz' => $isFiz]) ?></p>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab-measurements" aria-labelledby="profile-tab">
                    <?php echo $this->render('_tab_measurements', [
                        'model' => $model,
                        'measurements' => $measurements,
                        'isFiz' => $isFiz
                    ]) ?>
                </div>
                <div role="tabpanel" class="tab-pane   fade" id="tab-dogs" aria-labelledby="profile-tab">
                    <p><?php echo $this->render('_tab_dogs', ['model' => $model, 'dogs' => $dogs, 'isFiz' => $isFiz]) ?></p>
                </div>
            </div>
        </div>
</div>

