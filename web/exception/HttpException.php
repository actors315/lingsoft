<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/7/16
 * Time: 19:44
 */

namespace lingyin\web\exception;


use lingyin\base\exception\Exception;

class HttpException extends Exception
{

    public $statusCode;

    public function __construct($status, $message = null, $code = 0, \Exception $previous = null)
    {
        $this->statusCode = $status;
        parent::__construct($message, $code, $previous);
    }



}