<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/29
 * Time: 20:39
 */

namespace lingyin\base;


class Controller extends Component
{

    public $module;

    /**
     * @var View 模板渲染对象
     */
    private $_view;

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

    public function runAction()
    {
        $module = $this->module;
        while ($module->action === null) {
            $module = $module->module;
        }
        $this->{$module->action}();
    }


    public function beforeAction($action)
    {

    }

}