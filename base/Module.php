<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/18
 * Time: 16:45
 */

namespace lingyin\base;


use lingyin\base\exception\InvalidParamException;
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
     * @var string 模块标识
     */
    public $id;

    /**
     * @var string 控制器命名空间
     */
    public $controllerNamespace;

    /**
     * @var 模块根目录
     */
    private $_basePath;

    /**
     * @var string 模板view文件根目录
     */
    private $_viewPath;


    /**
     * 获取模块目录
     */
    public function getBasePath()
    {

        return $this->_basePath;
    }

    public function setBasePath($path)
    {
        $path = Ling::getAlias($path);
        $p = realpath($path);
        if ($p !== false && is_dir($p)) {
            return $this->_basePath = $p;
        }

        throw new InvalidParamException("The directory does not exist: $path");
    }


    public function getViewPath()
    {
        if ($this->_viewPath === null) {
            $this->_viewPath = $this->getBasePath() . DIRECTORY_SEPARATOR . 'views';
        }

        return $this->_viewPath;
    }

}