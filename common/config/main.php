<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'en-US',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'db' => 'db',
                    'sourceLanguage' => 'en-US',
                    'sourceMessageTable' => '{{%language_source}}',
                    'messageTable' => '{{%language_translate}}',
                    'cachingDuration' => 86400,
                    'enableCaching' => true,
                ],
            ],
        ],
        'settings' => [
            'class' => 'yii2mod\settings\components\Settings',
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin']
        ],
        'translatemanager' => [
            'class' => 'lajax\translatemanager\Module',
            'layout' => '@backend/views/themes/admin/layouts/main'
        ],
        'rbac' => 'dektrium\rbac\RbacWebModule',
        'redactor' => [
            'class' => 'yii\redactor\RedactorModule',
            'uploadDir' => '@webroot/uploads/wysiwyg',
            'uploadUrl' => '@web/uploads/wysiwyg',
            'imageAllowExtensions' => ['jpg', 'png', 'gif']
        ],
    ],
];
