<?php
use \yii\bootstrap\ActiveForm;
use \yii\helpers\Url;
use yii\helpers\StringHelper;

$this->title = 'Диалоги';

/** @var $sendForm \frontend\forms\MessageSendForm */
$currentUserId = Yii::$app->user->id;
?>
<div class="clearfix"></div>
<h2>Ваши диалоги</h2>
<?php if (count($dialogs) > 0): ?>
<div id="dialogs" class="row">
    <div class="col-lg-12 messages-list">
        <div class="row messages-items">
            <?php foreach ($dialogs as $item):
                if ($item['user_1'] == $currentUserId) {
                    $opponentName = $item['userName2'];
                    $opponentAvatar = $item['avatar2'];
                } else {
                    $opponentName = $item['userName1'];
                    $opponentAvatar = $item['avatar1'];
                }
                if (!$opponentAvatar) {
                    $opponentAvatar = '/images/user.png';
                }
                //$isMsgMy = (Yii::$app->user->id == $item['user1'])
                //    && (Yii::$app->user->id == $item['user2']);
                ?>
                <a class="col-lg-12 dialogs-item" href="<?= Url::to(['/messages/dialog', 'id' => $item['id']]) ?>">
                    <img class="dialogs-item-avatar pull-left" src="<?= $opponentAvatar ?>">
                    <span><b><?= htmlspecialchars($opponentName) ?></b></span><br>

                    <span class="fa hide fa-comment<?= ( 1) ? '-o' : '' ?>"></span>
                    <?= $item['msg_user_id'] == $currentUserId ? '<b>Вы:</b>' : '' ?>
                    <?= htmlspecialchars(StringHelper::truncate($item['text'], 100) ) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php else: ?>
    <p style="color: #7a7a7a;">У Вас нет открытых диалогов</p>
<?php endif; ?>

<style type="text/css">
    #dialogs {
        padding: 10px 0 10px 0;
        height: 75% !important;
        border: 1px solid #6e8aaa;
        border-radius: 5px;
    }

    .dialogs-items {
        height: 500px;
    }

    .dialogs-item{
        margin: 0 0 10px 0;
        width: 100%;
        cursor: pointer;
        display: block;
    }

    .dialogs-item :hover a{
    }

    .dialogs-item-avatar {
        border-radius: 50%;
        width: 44px;
        margin-right: 5px;
    }
</style>