<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/17
 * Time: 16:36
 */

namespace lingyin\di;

use lingyin\base\exception\InvalidConfigException;
use lingyin\base\Ling;

/**
 * 创建实例
 *
 * Class Instance
 * @package lingyin\di
 */
class Instance
{

    public $id;

    protected function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * 创建一个新的Instance对象
     *
     * @param $id
     * @return static
     */
    public static function of($id){
        return new static($id);
    }

    /**
     * 获取引用实际对象
     *
     * @param string | object $reference
     * @param string $type 预期返回的对象类型
     * @param null|Container $container 实例容器
     * @return object
     * @throws InvalidConfigException
     */
    public function ensure($reference, $type = null, $container = null)
    {
        if (empty($reference)) {
            throw new InvalidConfigException('LostRequireComponent');
        }

        if (is_string($reference)) {
            $reference = new static($reference);
        } elseif ($type == null || $reference instanceof $type) {
            return $reference;
        }

        if ($reference instanceof self) {
            $component = $reference->get($container);
            if ($type == null || $component instanceof $type) {
                return $component;
            } else {
                throw new InvalidConfigException();
            }
        }

        $valueType = is_object($reference) ? get_class($reference) : gettype($reference);
        throw new InvalidConfigException("Invalid data type: $valueType. $type is expected.");
    }

    /**
     * @param Container $container
     * @return mixed
     */
    public function get($container = null)
    {
        if ($container) {
            return $container->get($this->id);
        }

        return Ling::getContainer()->get($this->id);
    }
}