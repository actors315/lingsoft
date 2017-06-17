<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/17
 * Time: 21:43
 */

namespace lingyin\di;

use lingyin\base\exception\InvalidConfigException;
use lingyin\base\Ling;

/**
 * 服务注册器
 *
 * Class ServiceLocator
 * @package lingyin\di
 */
class ServiceLocator
{

    /**
     * 共享组件索引
     *
     * @var array
     */
    private $_components = [];

    /**
     * 可实例化组件定义索引
     *
     * @var array
     */
    private $_definitions = [];

    public function __get($name)
    {
        if (isset($this->_components[$name]) || isset($this->_definitions[$name])) {
            $this->get($name);
        }
    }

    /**
     * 获取组件实列
     *
     * @param $id
     * @return mixed
     * @throws InvalidConfigException
     */
    public function get($id)
    {
        if (isset($this->_components[$id])) {
            return $this->_components[$id];
        } elseif (isset($this->_definitions[$id])) {
            $definition = $this->_definitions[$id];
            // 匿名函数
            if (is_object($definition) && !$definition instanceof \Closure) {
                return $this->_components[$id] = $definition;
            }

            return $this->_components[$id] = Ling::createObject($definition);
        }

        throw new InvalidConfigException("Unknown component ID: $id");
    }

}