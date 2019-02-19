<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class DialogsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [];

    public $js = [
        'js/dialogs/dialog.js',
    ];
}
