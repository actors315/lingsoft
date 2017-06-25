<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/17
 * Time: 15:55
 */

namespace lingyin\cache;
use lingyin\base\Component;

/**
 * Cache基类，提供规范
 *
 * Class Cache
 * @package lingyin\cache
 */
abstract class Cache extends Component
{
    /**
     * 缓存命名空间
     *
     * @var string
     */
    public $keyPrefix = '';

    /**
     * 构建标准化key
     *
     * @param $key
     * @return string 格式化字符串
     */
    public function buildKey($key)
    {
        if (is_string($key)) {
            $key = ctype_alnum($key) ? $key : md5($key);
        } else {
            $key = md5(json_encode($key));
        }

        return $this->keyPrefix . $key;
    }

    /**
     * 获取缓存
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        $key = $this->buildKey($key);
        $value = $this->getValue($key);


        return $value;
    }

    /**
     * 设置缓存
     *
     * @param $key
     * @param $value
     * @param $expire
     * @return mixed
     */
    public function set($key, $value, $expire = 0)
    {
        $key = $this->buildKey($key);

        return $this->setValue($key, $value, $expire);
    }

    /**
     * @param $key
     * @return mixed
     */
    abstract protected function getValue($key);

    /**
     * @param $key
     * @param $value
     * @param $expire
     * @return mixed
     */
    abstract protected function setValue($key, $value, $expire);
}