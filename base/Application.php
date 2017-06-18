<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/18
 * Time: 16:36
 */

namespace lingyin\base;

/**
 * Class Application
 * @package lingyin\base
 */
abstract class Application extends Module
{

    /**
     * 需要在初始化时被加载的组件
     *
     * @var array
     */
    public $bootstrap = [];

    public function __construct($config = [])
    {
        Ling::$app = $this;

        $this->preInit($config);

        Component::__construct($config);
    }

    public function run()
    {

    }

    public function init()
    {
        parent::init();
        $this->bootstrap();
    }

    /**
     * 初始化前置操作
     *
     * @param $config
     */
    protected function preInit(&$config)
    {

    }

    /**
     * 初始化操作
     */
    protected function bootstrap()
    {

        foreach ($this->bootstrap as $class) {
            $component = null;

            if (is_string($class)) {

            }

            if ($component === null) {
                $component = Ling::createObject($class);
            }

            if ($component instanceof BootstrapInterface) {
                $component->bootstrap($this);
            }
        }
    }
}