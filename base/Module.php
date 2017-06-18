<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/18
 * Time: 16:45
 */

namespace lingyin\base;


use lingyin\di\ServiceLocator;

/**
 * 模块基类
 *
 * 模块包含MVC的实现
 *
 * Class Module
 * @package lingyin\base
 */
class Module extends ServiceLocator
{

    /**
     * @var 模块标识
     */
    public $id;

    /**
     * @var string 控制器命名空间
     */
    public $controllerNamespace;

    /**
     * @var string 模板view文件根目录
     */
    private $_viewPath;

}