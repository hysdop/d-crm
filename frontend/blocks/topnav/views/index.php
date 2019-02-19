<?php
use \yii\helpers\Url;
use \yii\helpers\Html;
/** @var $user \common\models\User */

?>
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="<?= $user->userProfile->getAvatarUrl() ?>" alt=""><?= htmlspecialchars(trim($user->userProfile->firstname . ' ' . $user->userProfile->lastname) ? : $user->username) ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="<?= Url::to(['/user/default/view']) ?>"> Профиль</a></li>
                        <li>
                            <a href="<?= Url::to(['/user/default']) ?>">
                                <span class="badge bg-red pull-right hide">50%</span>
                                <span>Настройки</span>
                            </a>
                        </li>
                        <li><a href="javascript:;">Справка</a></li>
                        <li>
                            <?= Html::a('Выход', ['/user/sign-in/logout'], ['class'=> 'fa fa-sign-out pull-right',  'data' => ['method' => 'post']]) ?>
                        </li>
                    </ul>
                </li>

                <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <?php if ($cntMsgs > 0): ?>
                            <span class="badge bg-green"><?= $cntMsgs ?></span>
                        <?php endif; ?>
                    </a>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        <li>
                            <?php foreach($lastMsgs as $k => $item): //if ($k > 2) break;  ?>
                            <a href="<?= Url::to(['/messages/dialog', 'id' => $item['id']]) ?>">
                                <span class="image"><img style="border-radius: 50%;" src="<?= $item['avatar'] ? $item['avatar'] : '/images/user.png' ?>" alt="Profile Image" /></span>
                                <span>
                                  <span><?= htmlspecialchars($item['userName']) ?></span>
                                  <span class="time"><?= Yii::$app->formatter->asDatetime($item['created_at'], 'php: d M H:i') ?></span>
                                </span>
                                <span class="message">
                                  <?= htmlspecialchars($item['text']) ?>
                                </span>
                            </a>
                            <?php  endforeach; ?>
                        </li>
                        <li>
                            <div class="text-center">
                                <a href="<?= Url::to(['/messages']) ?>">
                                    <strong>Открыть все сообщения</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>