<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/18
 * Time: 17:30
 */

namespace lingyin\base;

/**
 * 自定义初始化操作
 *
 * Interface BootstrapInterface
 * @package lingyin\base
 */
interface BootstrapInterface
{

    /**
     * Bootstrap method
     *
     * @param Application $application 当前运行对象
     * @return mixed
     */
    public function bootstrap($application);
}