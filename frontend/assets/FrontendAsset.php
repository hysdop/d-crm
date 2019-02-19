<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/libs/bootstrap.css',
        'css/libs/font-awesome/css/font-awesome.min.css',
        'css/libs/bootstrap-theme.css',
        '/css/animate.min.css',
        'css/libs/nprogress.css',
        'css/custom.css',
        'css/suggestions.css'
    ];

    public $js = [
        // 'js/jquery.min.js',
        'js/bootstrap.js',
        'js/fastclick.js',
        'js/nprogress.js',
        //'/js/icheck.min.js',
        '/js/moment.min.js',
        // '/js/jquery.hotkeys.js',
        // '/js/prettify.js',
        'js//autosize.min.js',
        'js/jquery.autocomplete.min.js',
        'js/custom.js',
        'js/jquery.suggestions.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        // 'common\assets\Html5shiv',
    ];
}
