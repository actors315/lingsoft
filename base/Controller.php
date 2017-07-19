<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/29
 * Time: 20:39
 */

namespace lingyin\base;

/**
 * Class Controller
 * @package lingyin\base
 * @property Module $module
 */
abstract class Controller extends Component implements ViewContextInterface
{

    public $module;

    private $_viewPath;

    /**
     * Controller constructor.
     * @param Module $module
     * @param array $config
     */
    public function __construct($module = null, $config = [])
    {
        $this->module = $module;
        parent::__construct($config);
    }

    public function beforeAction($action)
    {
    }

    public function runAction()
    {
        $module = $this->module;
        while ($module->action === null) {
            $module = $module->module;
        }
        return $this->{$module->action}();
    }

    public function render($view, $params = [])
    {
        return Ling::$app->getView()->render($view, $params, $this);
    }

    public function getViewPath()
    {
        if($this->_viewPath === null){
            return $this->module->getViewPath();
        }
        return $this->_viewPath;
    }

    public function setViewPath($path)
    {
        $this->_viewPath = Ling::getAlias($path);
    }
}