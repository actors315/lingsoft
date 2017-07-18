<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/18
 * Time: 16:43
 */

namespace lingyin\web;

use lingyin\helpers\StringHelper;

class Application extends \lingyin\base\Application
{

    /**
     * 处理请求
     *
     * @param \lingyin\web\Request $request
     */
    function handleRequest($request)
    {
        $route = $request->resolve();
        foreach ($route->attributes as $name => $value) {
            if ('module' == $name) {
                $this->module = strtolower($value);
            } elseif ('controller' == $name) {
                $this->controller = StringHelper::convertUnderline($value) . 'Controller';
            } elseif ('action' == $name) {
                $this->action = 'action' . StringHelper::convertUnderline($value);
            }
            $request->withAttribute($name, $value);
        }

        $this->runAction();
    }
}