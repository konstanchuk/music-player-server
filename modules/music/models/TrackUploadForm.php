<?php

namespace modules\music\models;

use yii\base\Model;
use yii\web\UploadedFile;

class TrackUploadForm extends Model
{
    /**
     * @var UploadedFile|Null file attribute
     */
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file'],
        ];
    }
}