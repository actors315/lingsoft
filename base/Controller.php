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

    public $action;

    /**
     * @var View 模板渲染对象
     */
    private $_view;

    public function __construct($action, $config = [])
    {
        $this->action = $action;
        parent::__construct($config);
    }

    public function runAction()
    {
        $this->{$this->action}();
    }


    public function beforeAction($action)
    {

    }

}