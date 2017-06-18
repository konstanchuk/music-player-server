<?php

namespace modules\music;

use yii\web\AssetBundle;


class ModuleAsset extends AssetBundle
{
    public $sourcePath = '@music-assets';

    public $css = [
        'jstree/dist/themes/default/style.min.css',
    ];

    public $js = [
        'jstree/dist/jstree.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}