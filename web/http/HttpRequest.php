<?php
/**
 * Created by PhpStorm.
 * User: xiehuanjin
 * Date: 2017/7/13
 * Time: 12:39
 */

namespace lingyin\web\http;


use lingyin\base\Request;

/**
 * HTTP请求处理
 *
 * http请求由三部分组成，分别是：请求行、消息报头、请求正文
 *
 * Class HttpRequest
 * @package lingyin\web\http
 */
abstract class HttpRequest extends Request
{
    /**
     * 请求行
     *
     * 请求行包含请求方法 uri 和协议版本
     * 如: POST /index.php HTTP1.1
     *
     * @var
     */
    protected $_line;

    /**
     * 请求头
     *
     * @var array
     */
    protected $_header;

    /**
     * 请求数据
     *
     * @var
     */
    protected $_body;

}