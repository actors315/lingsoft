<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/18
 * Time: 20:08
 */

namespace lingyin\base;


abstract class ViewRenderer extends Component
{
    abstract public function render($view, $file, $params);
}