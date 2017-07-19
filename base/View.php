<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/18
 * Time: 19:58
 */

namespace lingyin\base;
use lingyin\base\exception\InvalidConfigException;

/**
 * 模板
 *
 * Class View
 * @package lingyin\base
 */
abstract class View extends Component
{

    public $defaultExtension = 'php';

    public $renderWorker;

    public function render($view, $params = [], $context = null)
    {
        $viewFile = $this->findViewFile($view, $context);
        return $this->renderFile($viewFile, $params, $context);
    }

    protected function renderFile($viewFile, $params = [], $context = null)
    {
        $viewFile = Ling::getAlias($viewFile);
        $ext = pathinfo($viewFile, PATHINFO_EXTENSION);
        if (isset($this->renderWorker[$ext])) {
            $render = Ling::createObject($this->renderWorker[$ext]);
            return $render->render($this, $viewFile, $params);
        }

        throw new InvalidConfigException("未找到模板文件{$viewFile}");
    }

    /**
     * @param $view
     * @param null | \lingyin\web\Controller | \lingyin\base\Controller $context
     * @return string
     */
    protected function findViewFile($view, $context = null)
    {
        if (strncmp($view, '@', 1) === 0) {
            $file = Ling::getAlias($view);
        } elseif (strncmp($view, '//', 2) === 0) {

        } elseif (strncmp($view, '/', 1) === 0) {

        } elseif ($context instanceof ViewContextInterface) {
            $file = $context->getViewPath() . DIRECTORY_SEPARATOR . $view;
        }
        if (pathinfo($file, PATHINFO_EXTENSION) !== '') {
            return $file;
        }
        return $file . '.' . $this->defaultExtension;
    }
}