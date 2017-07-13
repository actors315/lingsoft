<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/7/13
 * Time: 22:41
 */

namespace lingyin\base;


interface RouteInterface
{
    /**
     * @param Request $request
     */
    function parse($request);
}