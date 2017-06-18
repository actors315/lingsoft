<?php

/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/17
 * Time: 15:57
 */

namespace lingyin\cache\redis;

class Cache extends \lingyin\cache\Cache
{
    public $redis = 'redis';

    /**
     * @param $key
     * @return mixed
     */
    function getValue($key)
    {

    }

    /**
     * @param $key
     * @param $value
     * @param $expire
     * @return mixed
     */
    function setValue($key, $value, $expire)
    {

    }
}