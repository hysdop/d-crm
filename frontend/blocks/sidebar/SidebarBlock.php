<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 21.04.17
 * Time: 16:50
 */

namespace frontend\blocks\sidebar;

use yii\base\Widget;

class SidebarBlock extends Widget
{
    public function run()
    {
        return $this->render('index', [
            'user' => \Yii::$app->user->identity
        ]);
    }
}
