<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/18
 * Time: 16:45
 */

namespace lingyin\base;


use lingyin\base\exception\InvalidConfigException;
use lingyin\base\exception\InvalidParamException;
use lingyin\base\exception\InvalidRouteException;
use lingyin\di\ServiceLocator;
use lingyin\web\Controller;

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
     * @var Module 父模块
     */
    public $module;

    public $controller;

    public $action;

    /**
     * @var array 模块
     */
    private $_modules = [];

    /**
     * @var 模块根目录
     */
    private $_basePath;

    /**
     * @var string 模板view文件根目录
     */
    private $_viewPath;

    public function __construct($id, $parent = null, array $config = [])
    {
        $this->id = $id;
        $this->module = $parent;
        parent::__construct($config);
    }


    /**
     * 获取模块目录
     *
     * @return string
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

    public function runAction()
    {
        $module = $this->getModule($this->module);
        $controller = $module->createController();
        if (false === $controller) {
            throw new InvalidRouteException("Unable to resolve the request.");
        }
        return $controller->runAction();
    }

    /**
     * @return bool| Controller | \lingyin\base\Controller
     * @throws InvalidConfigException
     */
    public function createController()
    {
        $module = $this->module;
        while ($module !== null && $module->controller === null) {
            $module = $module->module;
        }
        $className = ltrim($this->controllerNamespace . '\\' . $module->controller);
        if (!class_exists($className)) {
            return false;
        }

        if (is_subclass_of($className, 'lingyin\base\Controller')) {
            $controller = Ling::createObject($className, [$module]);
            return get_class($controller) === $className ? $controller : false;
        }

        throw new InvalidConfigException('Controller class must extend from \\lingyin\\base\\Controller.');
    }

    /**
     * 获取一个模块
     *
     * @param string $id 模块ID
     * @return Module
     */
    public function getModule($id)
    {
        if ($id === null || !isset($this->_modules[$id])) {
            return $this->module = $this;
        }

        return Ling::createObject($this->_modules[$id], [$id, $this]);
    }

    /**
     * 注册模块
     *
     * @param array $modules 模块数组
     */
    public function setModules($modules)
    {
        foreach ($modules as $id => $module) {
            $this->_modules[$id] = $module;
        }
    }

}