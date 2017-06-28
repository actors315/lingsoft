<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/28
 * Time: 20:12
 */

namespace lingyin\base;

/**
 * 辅助接口
 *
 * 接口不提供任何规范，配置的组件在服务定位时把参数传给构造方法的最后一个参数
 *
 * 'components' => [
 *       'redis' => [
 *           'class' => 'lingyin\cache\redis\Cache',
 *           'keyPrefix' => 'mifan:',
 *           'redis' => [
 *               'hostname' => '127.0.0.1',
 *               'port' => 6379,
 *               'database' => 0,
 *               'password' => 'xxxxxx',
 *           ]
 *       ]
 *   ]
 *
 * Interface ConfigurableInterface
 * @package lingyin\base
 */
interface ConfigurableInterface
{

}