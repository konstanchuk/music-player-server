<?php

namespace api\exceptions;


class HttpException extends \yii\web\HttpException
{
    protected $errorList;

    public function __construct($status, $message = null, $errorList = array(), $code = 0, \Exception $previous = null)
    {
        parent::__construct($status, $message, $code, $previous);
        $this->errorList = (array)$errorList;
    }

    public function getErrorList()
    {
        return $this->errorList;
    }
}