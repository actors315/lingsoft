<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/7/16
 * Time: 19:44
 */

namespace lingyin\web\exception;


class NotFoundHttpException extends HttpException
{
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct(404, $message, $code, $previous);
    }
}