<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/18
 * Time: 16:43
 */

namespace lingyin\web;


use lingyin\base\Request;

class Application extends \lingyin\base\Application
{

    /**
     * 处理请求
     *
     * @param Request $request
     */
    function handleRequest($request)
    {
        $request->resolve();
    }
}