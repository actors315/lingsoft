<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/17
 * Time: 20:36
 */

namespace lingyin\di;


use lingyin\base\exception\InvalidConfigException;

class NotInstantiableException extends InvalidConfigException
{

    public function __construct($class,$message = null, $code = 0, \Exception $previous = null)
    {
        if ($message === null) {
            $message = "Can not instantiate $class.";
        }
        parent::__construct($message, $code, $previous);
    }

    public function getName()
    {
        return 'Can not instantiable';
    }

}