<?php

use \yii\helpers\Url;
use \common\components\Icons;

/** @var $user \common\models\User */
?>

<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="/" class="site_title"><img src="/images/minilogo.png"> <span>BertaCRM</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="<?= $user->userProfile->getAvatarUrl() ?>" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Привет,</span>
                <h2><?= htmlspecialchars((trim(($user->userProfile->firstname . ' ' . $user->userProfile->lastname))) ? : $user->username) ?></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>Основные</h3>
                <ul class="nav side-menu">
                    <?php if(Yii::$app->user->can('boss')): ?>
                    <li class="<?= (in_array(Yii::$app->controller->module->id, ['settings', 'user'])) ? 'current-page':'' ?>">
                        <a href="<?= Url::to(['/settings/index']) ?>"><i class="<?= Icons::getClass(Icons::SETTINGS) ?>"></i> Настройки</a>
                    </li>
                    <?php endif; ?>
                    <li class="<?= (in_array(Yii::$app->controller->module->id, ['comings'])) ? 'current-page':'' ?>">
                        <a href="<?= Url::to(['/comings/index']) ?>"><i class="<?= Icons::getClass(Icons::COMING) ?>"></i> Обращения</a>
                    </li>
                    <li class="<?= (in_array(Yii::$app->controller->module->id, ['clients'])) ? 'current-page':'' ?>">
                        <a href="<?= Url::to(['/clients/index']) ?>"><i class="<?= Icons::getClass(Icons::USERS) ?>"></i> Клиенты</a>
                    </li>
                    <li class="<?= (in_array(Yii::$app->controller->module->id, ['measurements'])) ? 'current-page':'' ?>">
                        <a href="<?= Url::to(['/measurements/index']) ?>"><i class="fa fa-crop"></i> Замеры</a>
                    </li>
                    <li class="<?= (in_array(Yii::$app->controller->module->id, ['dogs'])) ? 'current-page':'' ?>">
                        <a href="<?= Url::to(['/dogs/index']) ?>"><i class="<?= Icons::getClass(Icons::DOG) ?>"></i> Договора</a>
                    </li>
                    <li class="<?= (in_array(Yii::$app->controller->module->id, ['kassa'])) ? 'current-page':'' ?>">
                        <a href="<?= Url::to(['/kassa/index']) ?>"><i class="fa fa-money"></i> Касса</a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/']) ?>"><i class="fa fa-wrench"></i> Рекламации</a>
                    </li>
                </ul>
            </div>
            <div class="menu_section hide">
                <h3>Live On</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="e_commerce.html">E-commerce</a></li>
                            <li><a href="projects.html">Projects</a></li>
                            <li><a href="project_detail.html">Project Detail</a></li>
                            <li><a href="contacts.html">Contacts</a></li>
                            <li><a href="profile.html">Profile</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="page_403.html">403 Error</a></li>
                            <li><a href="page_404.html">404 Error</a></li>
                            <li><a href="page_500.html">500 Error</a></li>
                            <li><a href="plain_page.html">Plain Page</a></li>
                            <li><a href="login.html">Login Page</a></li>
                            <li><a href="pricing_tables.html">Pricing Tables</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="#level1_1">Level One</a>
                            <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="sub_menu"><a href="level2.html">Level Two</a>
                                    </li>
                                    <li><a href="#level2_1">Level Two</a>
                                    </li>
                                    <li><a href="#level2_2">Level Two</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="#level1_2">Level One</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
                </ul>
            </div>

        </div>
        <!-- /sidebar menu -->
    </div>
</div>