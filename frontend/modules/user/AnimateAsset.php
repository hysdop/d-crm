<?php

namespace frontend\modules\user;

use yii\web\AssetBundle;

/**
 * Description of AnimateAsset
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 2.5
 */
class AnimateAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@backend/modules/user/assets';
    /**
     * @inheritdoc
     */
    public $css = [
        'animate.css',
    ];

}
