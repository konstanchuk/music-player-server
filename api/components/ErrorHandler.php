<?php

namespace api\components;

use Yii;
use yii\web\HttpException;
use yii\web\Response;


class ErrorHandler extends \yii\web\ErrorHandler
{
    protected function renderException($exception)
    {
        if (Yii::$app->has('response')) {
            $response = Yii::$app->getResponse();
        } else {
            $response = new Response();
        }
        $response->data = $this->convertExceptionToArray($exception);
        $response->setStatusCode($exception instanceof HttpException ? $exception->statusCode : 500);
        $response->send();
    }

    protected function convertExceptionToArray($exception)
    {
        $data = [
            'error' => [
                'name' => $exception->getName(),
                'code' => $exception instanceof HttpException ? $exception->statusCode : 500,
                'message' => $exception->getMessage()
            ]
        ];

        if ($exception instanceof \api\exceptions\HttpException) {
            $list = $exception->getErrorList();
            if (count($list)) {
                $data['error']['list'] = $list;
            }
        }

        return $data;
    }
}