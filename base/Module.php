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

    public $controller = 'IndexController';

    public $action = 'actionIndex';

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

    public function runAction()
    {
        $controller = $this->createController();
        if (false === $controller) {
            throw new InvalidRouteException("Unable to resolve the request {$this->controller}/{$this->action}.");
        }
        $controller->runAction();
    }

    /**
     * @return bool| Controller | \lingyin\base\Controller
     * @throws InvalidConfigException
     */
    public function createController()
    {
        $className = ltrim($this->controllerNamespace . '\\' . $this->controller);
        if (!class_exists($className)) {
            return false;
        }

        if (is_subclass_of($className, 'lingyin\base\Controller')) {
            $controller = Ling::createObject($className, [$this->action]);
            return get_class($controller) === $className ? $controller : false;
        }

        throw new InvalidConfigException('Controller class must extend from \\lingyin\\base\\Controller.');
    }

}