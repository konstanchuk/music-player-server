<?php

namespace modules\music;


class Module extends \yii\base\Module
{

    public $uploadDir = '@webroot/uploads/genre-images';
    public $uploadUrl = '@web/uploads/genre-images';

    public $uploadThumbs = [
        'small' => [80, 80],
        'medium' => [120, 120]
    ];

    public $assets = '';

    public function init()
    {
        parent::init();
        $this->setAliases(['@music-assets' => __DIR__ . '/assets']);
    }
}