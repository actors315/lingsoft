<?php
/**
 * Created by PhpStorm.
 * User: xiehuanjin
 * Date: 2017/7/13
 * Time: 12:55
 */

namespace lingyin\web\http;


interface HeaderInterface
{
    function setHeader($key, $value);

    function getHeader($key);

}