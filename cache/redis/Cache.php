<?php

/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/17
 * Time: 15:57
 */

namespace lingyin\cache\redis;

use lingyin\di\Instance;

class Cache extends \lingyin\cache\Cache
{

    /**
     * @var Connection null
     */
    public $instance = null;

    /**
     * @var array redis配置
     */
    public $redis = [];

    public $driver = PhpredisConnection::class;

    public function init()
    {
        parent::init();

        if (!$this->driver instanceof Connection) {
            $this->driver = PhpredisConnection::class;
        }

        $this->instance = Instance::ensure($this->redis, $this->driver);
    }

    /**
     * @param $key
     * @return mixed
     */
    protected function getValue($key)
    {
        return $this->instance->executeCommand('GET', [$key]);
    }

    /**
     * @param $key
     * @param $value
     * @param $expire
     * @return mixed
     */
    protected function setValue($key, $value, $expire = 0)
    {
        if ($expire == 0) {
            return $this->instance->executeCommand('SET', [$key, $value]);
        }

        $expire = (int)($expire * 1000);

        return $this->instance->executeCommand('PSETEX', [$key, $expire, $value]);
    }
}