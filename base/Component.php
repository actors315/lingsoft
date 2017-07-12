<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/18
 * Time: 16:38
 */

namespace lingyin\base;

use lingyin\base\exception\UnknownPropertyException;

/**
 * 组件基类
 *
 * Class Component
 * @package lingyin\base
 */
class Component implements ConfigurableInterface
{

    public function __construct($config = [])
    {
        var_dump($this);
        if (!empty($config)) {
            Ling::setProperties($this, $config);
        }
        $this->init();
    }

    public function init()
    {

    }

    public function __get($name)
    {
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter)) {
            return $this->$getter($name);
        }
    }

    public function __set($name, $value)
    {
        $setter = 'set' . ucfirst($name);
        if (method_exists($this, $setter)) {
            return $this->$setter($value);
        }

        throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $name);
    }
}