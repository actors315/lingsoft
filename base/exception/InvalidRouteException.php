<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/7/16
 * Time: 20:38
 */

namespace lingyin\base\exception;


class InvalidRouteException extends Exception
{

    public function getName()
    {
        return 'Invalid Route';
    }
}