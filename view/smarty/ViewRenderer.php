<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/18
 * Time: 20:02
 */

namespace lingyin\view\smarty;


use lingyin\base\Ling;

class ViewRenderer extends \lingyin\base\ViewRenderer
{
    /**
     * @var string 模板缓存路径
     */
    public $cachePath = '@runtime/Smarty/cache';

    /**
     * @var string 模板解析文件路径
     */
    public $compilePath = '@runtime/Smarty/compile';

    /**
     * @var string 模板配置文件路径
     */
    public $configPath = '';

    /**
     * @var array 配置参数
     */
    public $options = [];

    /**
     * @var \Smarty 实例化Smarty对象
     */
    protected $_smarty;

    public function init()
    {
        parent::init();
        $this->_smarty = new \Smarty();

        foreach ($this->options as $key => $value) {
            $this->_smarty->$key = $value;
        }

        $this->_smarty->setTemplateDir([Ling::$app->getViewPath()]);
        $this->_smarty->setCompileDir(Ling::getAlias($this->compilePath));
        $this->_smarty->setCacheDir(Ling::getAlias($this->cachePath));
        if(!empty($this->configPach)){
            $this->_smarty->setConfigDir(Ling::getAlias($this->configPath));
        }
    }

    /**
     * @param $view
     * @param $file
     * @param $params
     * @return mixed
     */
    public function render($view, $file, $params = [])
    {
        foreach ($params as $key => $value){
            $this->_smarty->assign($key,$value);
        }
        $this->_smarty->assign('this',$view);
        $this->_smarty->assign('app',Ling::$app);
        return $this->_smarty->fetch($file);
    }
}