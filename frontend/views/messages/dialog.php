<?php
use \yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use \yii\helpers\Url;

/** @var $sendForm \frontend\forms\MessageSendForm */

\frontend\assets\DialogsAsset::register($this);

$currentUserId = Yii::$app->user->id;

$lastItemId = count($messages) > 0 ? end($messages)['id'] : 0;

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

if ($currentUserId == $dialog['user_2']) {
    $opponentName   = $dialog['userName1'];
    $opponentAvatar = $dialog['avatar1'];
    $opponentId     = $dialog['user_1'];
} else {
    $opponentName   = $dialog['userName2'];
    $opponentAvatar = $dialog['avatar2'];
    $opponentId     = $dialog['user_2'];
}
if ($opponentAvatar == '') {
    $opponentAvatar = '/images/user.png';
}

$this->title = $opponentName;
?>

<div class="clearfix"></div>
<div id="messages" class="row">
    <div class="col-lg-12 messages-list">
        <div class="panel panel-info">
            <div class="panel-heading">
                <span><img class="img-circle" src="<?= $opponentAvatar ?>" width="32"> <a target="_blank" href="<?= Url::to(['/user/default/view', 'id' => $opponentId]) ?>"><?= $opponentName ?></a></span>
            </div>
            <div class="panel-body">
                <div class="messages-items" id="messages-items">
                    <ul class="media-list" style="list-style-type: none;">
                    <?php foreach ($messages as $item):

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
                    <li class="media <?= $item['read_at'] ? '' : 'notreaded' ?>">

                        <div class="media-body">

                            <div class="media">
                                <a class="pull-left" href="#">
                                    <img class="media-object img-circle " width="64" src="<?= $senderAvatar ?>">
                                </a>
                                <div class="media-body">
                                    <small class="text-muted"><a target="_blank" href="<?= Url::to(['/user/default/view', 'id' => $item['user_id']]) ?>"><?= htmlspecialchars($senderName) ?></a> | <?= Yii::$app->formatter->asDatetime($item['created_at'], 'php:Y-m-d, H:i') ?></small>
                                    <br>

                                    <b><?= htmlspecialchars($item['text']) ?></b>
                                    <hr>
                                </div>
                            </div>

                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                </div>
            </div>
            <div class="panel-footer">
                <div id="send-form">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Введите сообщение">
                        <span class="input-group-btn">
                            <button class="btn btn-info" type="button">ОТПРАВИТЬ</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->render('_message_tmp'); ?>

<style type="text/css">
    #messages {
        padding: 10px 10px 10px 10px;
        height: 75% !important;
    }

    .notreaded{
        background-color: #d0f1f8;
    }

    .messages-items {
        height: 440px !important;
        overflow-y: scroll;
    }

    .comment-item .time{

    }

    #messages  .media-list li{
        margin: 0;
    }

    #messages  .media-list li b{
        color: #2e2e2e;
    }

    .comment-item-avatar {
        border-radius: 50%;
        width: 24px;
        margin-right: 5px;
    }
</style>