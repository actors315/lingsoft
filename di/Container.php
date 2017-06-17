<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/17
 * Time: 17:31
 */

namespace lingyin\di;


class Container
{

    /**
     * @var array 单例对象索引
     */
    private $_singletons = [];

    /**
     * @var array 对象映射索引
     */
    private $_reflections = [];

    /**
     * @var array 对象依赖索引,包含构造函数的默认值
     */
    private $_dependencies = [];

    public function get($class)
    {
        if (isset($this->_singletons[$class])) {
            return $this->_singletons[$class];
        }
    }

    protected function build($class)
    {
        list ($reflection, $dependencies) = $this->getDependencies($class);


        $dependencies = $this->resolveDependencies($dependencies, $reflection);
        if ($reflection->isInstantiable() == false) {
            throw new NotInstantiableException($reflection->name);
        }

        return $reflection->newInstanceArgs($dependencies);

    }

    /**
     * 获取实例构造函数的默认值
     *
     * @param $class
     * @return array
     */
    protected function getDependencies($class)
    {
        if (isset($this->_reflections[$class])) {
            return [$this->_reflections[$class], $this->_dependencies[$class]];
        }

        $dependencies = [];
        $reflection = new \ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        if ($constructor !== null) {
            $parameters = $constructor->getParameters();
            foreach ($parameters as $param) {
                if ($param->isDefaultValueAvailable()) {
                    $dependencies[] = $param->getDefaultValue();
                } else {
                    $c = $param->getClass();
                    $dependencies[] = Instance::of($c === null ? null : $c->getName());
                }
            }
        }

        $this->_reflections[$class] = $reflection;
        $this->_dependencies[$class] = $dependencies;

        return [$reflection, $dependencies];
    }

    /**
     * 将参数中的对象替换成实例
     *
     * @param $dependencies
     * @param $reflection
     * @return mixed
     */
    protected function resolveDependencies($dependencies, $reflection)
    {
        foreach ($dependencies as $index => $dependency) {
            if ($dependency instanceof Instance) {
                if ($dependency->id !== null) {
                    $dependencies[$index] = $this->get($dependency->id);
                } elseif ($reflection !== null) {
                    $name = $reflection->getConstructor()->getParameters()[$index]->getName();
                    $class = $reflection->getName();
                    throw new InvalidConfigException("Missing required parameter \"｛$name}\" when instantiating \"{$class}\".");
                }
            }
        }
        return $dependencies;
    }
}