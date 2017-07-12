<?php
/**
 * Created by PhpStorm.
 * User: xiehuanjin
 * Date: 2017/7/12
 * Time: 12:45
 */

namespace lingyin\base\exception;


class UnknownPropertyException extends Exception
{

    public function getName()
    {
        return 'Unknown Property';
    }

}