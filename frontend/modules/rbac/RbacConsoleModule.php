<?php

namespace frontend\modules\rbac;

use yii\base\Module;

/**
 * Rbac console module.
 * 
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class RbacConsoleModule extends Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'dektrium\rbac\commands';
}