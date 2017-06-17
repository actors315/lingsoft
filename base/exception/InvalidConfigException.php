<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/17
 * Time: 16:55
 */

namespace lingyin\base\exception;


class InvalidConfigException extends Exception
{

    public function getName()
    {
        return 'Invalid Configuration';
    }
}