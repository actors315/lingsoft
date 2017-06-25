<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/17
 * Time: 19:23
 */
namespace lingyin\base;

use lingyin\base\exception\InvalidConfigException;
use lingyin\di\Container;

class Ling
{
    public static $app;

    /**
     * @var Container
     */
    public static $container = null;


    /**
     * 实例化对象
     *
     * @param string|array|callable $type
     * @param array $params
     * @return object
     * @throws InvalidConfigException
     */
    public static function createObject($type, array $params = [])
    {
        if (is_string($type)) {
            return static::getContainer()->get($type, $params);
        } elseif (is_array($type) && isset($type['class'])) {
            $class = $type['class'];
            unset($type['class']);
            return static::getContainer()->get($class, $params, $type);
        } elseif (is_callable($type, true)) {
            return static::getContainer()->invoke($type, $params);
        } elseif (is_array($type)) {
            throw new InvalidConfigException('Object configuration must be an array containing a "class" element.');
        }

        throw new InvalidConfigException('Unsupported configuration type: ' . gettype($type));
    }

    /**
     * 配置对象属性
     *
     * @param object $object
     * @param array $properties 需配置的属性,格式为[[key=>value']]
     * @return object
     */
    public static function setProperties($object, $properties)
    {
        foreach ($properties as $name => $value) {
            $object->$name = $value;
        }

        return $object;
    }

    /**
     * 获取依赖注入容器
     *
     * @return Container|null
     */
    public static function getContainer()
    {
        if (static::$container == null) {
            static::$container = new Container();
        }

        return static::$container;
    }

    /**
     * 将路径别名转换为实际路径
     *
     * @param $alias 路径别名
     * @return string
     */
    public static function getAlias($alias)
    {
        return $alias;
    }
}