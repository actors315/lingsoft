<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/7/12
 * Time: 22:09
 */

namespace lingyin\base;


abstract class Request extends Component
{
    protected $_path;

    abstract public function resolve();
}