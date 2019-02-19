<?php

use yii\helpers\Html;
use \common\repositories\DogsRepository;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\repositories\DogsRepository */

$this->title = 'Добавить договор';
$this->params['breadcrumbs'][] = ['label' => 'Договора', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dogs-repository-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="panel mypanel">
        <div class="panel-heading">
            <h3 class="panel-title">
                <?php switch ($fromType){
                    case DogsRepository::FROM_MEASUREMENT:
                        echo "<b>Замер:</b> <a href='" . Url::to(['/measurements/index/view', 'id' => $from['id']]) . "' 
                            target='_blank' title='Открыть' style='color:#404040;'>"
                            . htmlspecialchars($from['firstname'] . ' ' . $from['lastname']) . '</a>';
                        break;
                }  ?>
            </h3>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
