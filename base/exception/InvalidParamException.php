<?php
/**
 * Created by PhpStorm.
 * User: xiehuanjin
 * Date: 2017/7/12
 * Time: 12:51
 */

namespace lingyin\base\exception;


class InvalidParamException extends Exception
{
    public function getName()
    {
        return 'Invalid Parameter';
    }
}