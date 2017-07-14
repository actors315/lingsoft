<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/7/13
 * Time: 22:43
 */

namespace lingyin\web\router;

use lingyin\base\Ling;

class Route extends \lingyin\base\Route
{

    /**
     * @param \lingyin\web\Request $request
     */
    function parse($request)
    {
        $path = $request->getPath();

    }
}