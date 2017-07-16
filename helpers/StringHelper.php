<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/7/16
 * Time: 19:50
 */

namespace lingyin\helpers;


class StringHelper
{
    /**
     * 将下划线命名转换为驼峰式命名
     *
     * @param $str
     * @param bool $ucFirst 首字符是否大写
     * @return string
     */
    public static function convertUnderline($str, $ucFirst = true)
    {
        while (($pos = strpos($str, '_')) !== false)
            $str = substr($str, 0, $pos) . ucfirst(substr($str, $pos + 1));

        return $ucFirst ? ucfirst($str) : $str;
    }
}