<?php
$config = [
    'homeUrl' => Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => 'frontend\controllers',
    'language' => 'ru-RU',
    'defaultRoute' => 'site/index',
    'bootstrap' => ['maintenance'],
    'modules' => [
        'user' => [
            'class' => 'frontend\modules\user\Module',
            //'shouldBeActivated' => true
        ],
        'settings' => [
            'class' => 'frontend\modules\settings\Module',
        ],
        'admin' => [
            'class' => 'frontend\modules\admin\Module',
        ],
        'clients' => [
            'class' => 'frontend\modules\clients\Module',
        ],
        'comings' => [
            'class' => 'frontend\modules\comings\Module',
        ],
        'measurements' => [
            'class' => 'frontend\modules\measurements\Module',
        ],
        'dogs' => [
            'class' => 'frontend\modules\dogs\Module',
        ],
        'kassa' => [
            'class' => 'frontend\modules\kassa\Module',
        ],
        'api' => [
            'class' => 'frontend\modules\api\Module',
            'modules' => [
                'v1' => 'frontend\modules\api\v1\Module'
            ]
        ]
    ],
    'components' => [
        'formatter' => [
            'dateFormat' => 'php:j M Yг.',
            'timeFormat' => 'php:H:i',
            'datetimeFormat' => 'php:j M Yг, H:i',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'RU',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'maintenance' => [
            'class' => 'common\components\maintenance\Maintenance',
            'enabled' => function ($app) {
                return $app->keyStorage->get('frontend.maintenance') === 'enabled';
            }
        ],
        'request' => [
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY')
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\repositories\UserRepository',
            'loginUrl' => ['/user/sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin' => 'common\behaviors\LoginTimestampBehavior'
        ]
    ]
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'messageCategory' => 'frontend'
            ]
        ]
    ];
}

return $config;
