<?php

use yii\helpers\Html;
use \common\repositories\MeasurementsRepository;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\repositories\MeasurementsRepository */

$this->title = 'Новый замер';
$this->params['breadcrumbs'][] = ['label' => 'Замеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="measurements-repository-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="panel mypanel">
        <div class="panel-heading">
            <h3 class="panel-title">
                <?php switch ($fromType){
                    case MeasurementsRepository::FROM_COMING:
                        echo "<b>Обращение:</b> <a href='" . Url::to(['/comings/index/view', 'id' => $from['id']]) . "' 
                            target='_blank' title='Открыть' style='color:#404040;'>"
                            . htmlspecialchars($from['firstname'] . ' ' . $from['lastname']) . '</a>';
                        break;
                    case MeasurementsRepository::FROM_CLIENT:
                        echo "<b>Клиент:</b> <a href='" . Url::to(['/clients/index/view', 'id' => $from['id']]) . "' 
                            target='_blank' title='Открыть' style='color:#404040;'>"
                            . htmlspecialchars($from['firstname'] . ' ' . $from['lastname']) . '</a>';
                        break;
                }  ?>
            </h3>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'employee' => $employee,
        'employees' => $employees,
    ]) ?>

</div>
