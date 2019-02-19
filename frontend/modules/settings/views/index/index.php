<?php
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'Настройки';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="row">
    <div class="col-sm-4">
        <h3><span class="fa fa-building-o"></span> Компания</h3>
        <div id="treeview1" class="treeview">
            <ul class="list-group">
                <li class="list-group-item" data-nodeid="0">
                    <a href="<?= Url::to(['/settings/company']) ?>"> Карта дилера</a><br>
                </li>
                <li class="list-group-item" data-nodeid="1">
                    <a href="<?= Url::to(['/user/index']) ?>"> Сотрудники</a><br>
                </li>
                <li class="list-group-item" data-nodeid="1">
                    <a href="<?= Url::to(['/settings/office']) ?>"> Офисы</a><br>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-sm-4">
        <h3><span class="fa fa-building-o"></span> Справочники</h3>
        <div id="treeview1" class="treeview">
            <ul class="list-group accordion" role="tablist" aria-multiselectable="true">
            <?php foreach ($dirsTree as $i => $item): ?>
                <li class="list-group-item collapsed"  >
                    <a class="collapsed" id="headingOne<?= $i ?>" data-toggle="collapse" data-parent="#accordion<?= $i ?>" href="#collapseOne<?= $i ?>" aria-expanded="false" aria-controls="collapseOne">
                        <?= $i ?>
                    </a>
                    <div id="collapseOne<?= $i ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                        <div class="panel-body">
                        <?php foreach ($item as $k => $dirType): if ($k == 0) continue; ?>
                            <a href="<?= Url::to(['/settings/directories/index?DirectoriesSearch%5Btype%5D=' . $k]) ?>"> <?= $dirType ?></a><br>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="col-sm-4"></div>
</div>