<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/7/12
 * Time: 22:09
 */

namespace lingyin\web;

use lingyin\base\Ling;
use lingyin\web\exception\NotFoundHttpException;
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
        $matcher = Ling::$app->getRouter()->getMatcher();
        if ($route = $matcher->match($this)) {
            return $route;
        }
        throw new NotFoundHttpException('NotFound');
    }
}