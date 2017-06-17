<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/17
 * Time: 19:23
 */

namespace lingyin\base;


use lingyin\di\Container;

class Ling extends BaseLing
{

    public static function getContainer(){
        if (self::$container == null){
            self::$container = new Container();
        }

        return self::$container;
    }
}