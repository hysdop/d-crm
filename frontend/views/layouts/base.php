<?php

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/_clear.php')
?>

<?= $content ?>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; BertaCRM <?= date('Y') ?></p>
        <p class="pull-right"><?php //echo Yii::powered()  ?></p>
    </div>
</footer>
<?php $this->endContent() ?>
