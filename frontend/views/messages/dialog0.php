<?php
use \yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

/** @var $sendForm \frontend\forms\MessageSendForm */

\frontend\assets\DialogsAsset::register($this);
$lastItemId = 0;
$currentUserId = Yii::$app->user->id;
?>

<div class="clearfix"></div>
<div id="messages" class="row">
    <div class="col-lg-12 messages-list">
        <div class="row messages-items" id="messages-items">
            <?php foreach ($messages as $item):
                $lastItemId = $item['id'];

                $isMsgMy = ($currentUserId == $item['user_id']);
                if ($item['user_id'] == $dialog['user_1']) {
                    $senderName   = $dialog['userName1'];
                    $senderAvatar = $dialog['avatar1'];
                } else {
                    $senderName   = $dialog['userName2'];
                    $senderAvatar = $dialog['avatar2'];
                }
                if ($senderAvatar == '') {
                    $senderAvatar = '/images/user.png';
                }
                if ($isMsgMy) {
                    $senderName = 'Вы';
                }
                ?>

            <div class="col-lg-12 comment-item <?= $item['read_at'] ? '' : 'notreaded' ?>">
                <img class="comment-item-avatar pull-left" src="<?= $senderAvatar ?>">
                <span class="fa hide fa-comment<?= ($item['read_at'] || $isMsgMy) ? '-o' : '' ?>"></span>
                <span><b><?= htmlspecialchars($senderName) ?></b></span> <time><?= Yii::$app->formatter->asDatetime($item['created_at'], 'php:Y-m-d, H:i') ?></time>
                <p><?= htmlspecialchars($item['text']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="row" id="send-form">
    <div class="col-lg-12 col-md-12">
        <textarea class="form-control" style="width: 100%"></textarea>

        <button type="submit" class="btn btn-success pull-right">Отправить</button>
    </div>
</div>


<?= $this->render('_message_tmp'); ?>

<?php
    $this->registerJs("dialog.init({
            id: $dialog[id],
            currentUserId: $currentUserId,
            lastItemId: $lastItemId, 
            avatar1: '$dialog[avatar1]',
            avatar2: '$dialog[avatar2]',
            name1: '$dialog[userName1]',
            name2: '$dialog[userName2]',
            user_1: $dialog[user_1],
            user_2: $dialog[user_2]
        });");
?>

<style type="text/css">
    #messages {
        padding: 10px 10px 10px 10px;
        height: 75% !important;
        border: 1px solid #0a0a0a;
    }

    .notreaded{
        background-color: #d0f1f8;
    }

    .messages-items {
        height: 500px !important;
        overflow-y: scroll;
    }

    .comment-item time{
        color: #92a7c3;;
        font-size: 10px;
        font-weight: bold;
        float: right;
    }

    .comment-item{
        padding: 0 0 10px 0;
        width: 100%;
    }

    .comment-item-avatar {
        border-radius: 50%;
        width: 24px;
        margin-right: 5px;
    }
</style>