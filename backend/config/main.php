<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/backend',
        ],
        'user' => [
            //'identityClass' => 'common\models\User',
            //'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@backend/views/themes/admin',
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-red',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'modules' => [
        'settings' => [
            'class' => 'yii2mod\settings\Module',
            // Also you can override some controller properties in following way:
            'controllerMap' => [
                'default' => [
                    'class' => 'yii2mod\settings\controllers\DefaultController',
                    'searchClass' => [
                        'class' => 'yii2mod\settings\models\search\SettingSearch',
                        'pageSize' => 25
                    ],
                ]
            ]
        ],
        'music' => [
            'class' => 'modules\music\Module',
            'controllerNamespace' => 'modules\music\controllers\backend',
            'viewPath' => __DIR__ . '/../../modules/music/views/backend',
        ],
    ],
    'params' => $params,
];
