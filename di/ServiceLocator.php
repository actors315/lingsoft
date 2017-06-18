<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/17
 * Time: 21:43
 */

namespace lingyin\di;

use lingyin\base\Component;
use lingyin\base\exception\InvalidConfigException;
use lingyin\base\Ling;

/**
 * 服务注册器
 *
 * Class ServiceLocator
 * @package lingyin\di
 */
class ServiceLocator extends Component
{

    /**
     * 组件索引(已实例化的组件对象)
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
        if ($this->has($name)) {
            return $this->get($name);
        }

        return parent::__get($name);
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
        }

        if (isset($this->_definitions[$id])) {
            $definition = $this->_definitions[$id];
            if (is_object($definition) && !$definition instanceof \Closure) {
                return $this->_components[$id] = $definition;
            }

            return $this->_components[$id] = Ling::createObject($definition);
        }

        throw new InvalidConfigException("Unknown component ID: $id");
    }

    /**
     * 设置组件
     *
     * @param $id
     * @param $definition
     * @return array|callable|void
     * @throws InvalidConfigException
     */
    public function set($id, $definition)
    {
        if ($definition === null) {
            unset($this->_components[$id], $this->_definitions[$id]);
            return;
        }

        unset($this->_components[$id]);
        if (is_string($definition)) {
            return $this->_definitions[$id] = $definition;
        }

        if (is_object($definition) || is_callable($definition, true)) {
            return $this->_definitions[$id] = $definition;
        }

        if (is_array($definition)) {
            if (isset($definition['class'])) {
                return $this->_definitions[$id] = $definition;
            }

            throw new InvalidConfigException("The configuration for the \"$id\" component must contain a \"class\" element.");
        }

        throw new InvalidConfigException("Unexpected configuration type for the \"$id\" component: " . gettype($definition));
    }

    /**
     * 当前是否已包含某个实例
     *
     * @param $id
     * @param bool $checkInstance 默认false,只检查实例是否已创建,true检查实例是否可创建
     * @return bool
     */
    public function has($id, $checkInstance = false)
    {
        return $checkInstance ? isset($this->_components[$id]) : isset($this->_definitions[$id]);
    }

    public function setComponents($components)
    {
        foreach ($components as $id => $component) {
            $this->set($id, $component);
        }
    }
}