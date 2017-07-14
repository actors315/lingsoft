<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/7/12
 * Time: 22:09
 */

namespace lingyin\web;

use lingyin\base\Ling;
use lingyin\web\http\HttpRequest;

/**
 *
 * Class Request
 * @package lingyin\web
 */
class Request extends HttpRequest
{

    public function resolve()
    {
        Ling::$app->getRouter()->parse($this);

        print_r($this);
    }

    function setPath()
    {
        $this->_path = Ling::$app->getUriManager()->getPath();
    }
}