<?php
/**
 * Created by PhpStorm.
 * User: xiehuanjin
 * Date: 2017/7/13
 * Time: 12:59
 */

namespace lingyin\web\http;


class Header implements HeaderInterface
{
    protected $_headers = [];

    function setHeader($key, $value)
    {
        if ($value === null) {
            unset($this->_headers[$key]);
            return;
        }

        $this->_headers[$key] = $value;
    }

    function getHeader($key = null)
    {
        if ($key === null) {
            return $this->_headers;
        }

        return isset($this->_headers[$key]) ? $this->_headers[$key] : '';
    }
}