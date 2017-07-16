<?php
/**
 * Created by PhpStorm.
 * User: xiehuanjin
 * Date: 2017/7/13
 * Time: 12:39
 */

namespace lingyin\web\http;


use lingyin\base\Ling;
use lingyin\base\Request;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * HTTP请求处理
 *
 * http请求由三部分组成，分别是：请求行、消息报头、请求正文
 *
 * Class HttpRequest
 * @package lingyin\web\http
 */
abstract class HttpRequest extends Request implements ServerRequestInterface
{
    /**
     * 请求行部分
     *
     * 请求行包含请求方法 uri 和协议版本
     * 如: POST /index.php HTTP1.1
     *
     * @var
     */
    protected $_method;

    protected $_uri;

    protected $_protocol = 'HTTP/1.1';

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


    public function getProtocolVersion()
    {
        // TODO: Implement getProtocolVersion() method.
    }

    public function withProtocolVersion($version)
    {
        // TODO: Implement withProtocolVersion() method.
    }

    public function getHeaders()
    {
        // TODO: Implement getHeaders() method.
    }

    public function hasHeader($name)
    {
        // TODO: Implement hasHeader() method.
    }

    public function getHeader($name)
    {
        // TODO: Implement getHeader() method.
    }

    public function getHeaderLine($name)
    {
        // TODO: Implement getHeaderLine() method.
    }

    public function withHeader($name, $value)
    {
        // TODO: Implement withHeader() method.
    }

    public function withAddedHeader($name, $value)
    {
        // TODO: Implement withAddedHeader() method.
    }

    public function withoutHeader($name)
    {
        // TODO: Implement withoutHeader() method.
    }

    public function getBody()
    {
        // TODO: Implement getBody() method.
    }

    public function withBody(StreamInterface $body)
    {
        // TODO: Implement withBody() method.
    }

    public function getRequestTarget()
    {
        // TODO: Implement getRequestTarget() method.
    }

    public function withRequestTarget($requestTarget)
    {
        // TODO: Implement withRequestTarget() method.
    }

    public function getMethod()
    {
        // TODO: Implement getMethod() method.
    }

    public function withMethod($method)
    {
        // TODO: Implement withMethod() method.
    }

    public function getUri()
    {
        if ($this->_uri === null) {
            $this->withUri(Ling::$app->getUriManager());
        }

        return $this->_uri;
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $this->_uri = $uri;
    }

    public function getServerParams()
    {
        // TODO: Implement getServerParams() method.
    }

    public function getCookieParams()
    {
        // TODO: Implement getCookieParams() method.
    }

    public function withCookieParams(array $cookies)
    {
        // TODO: Implement withCookieParams() method.
    }

    public function getQueryParams()
    {
        // TODO: Implement getQueryParams() method.
    }

    public function withQueryParams(array $query)
    {
        // TODO: Implement withQueryParams() method.
    }

    public function getUploadedFiles()
    {
        // TODO: Implement getUploadedFiles() method.
    }

    public function withUploadedFiles(array $uploadedFiles)
    {
        // TODO: Implement withUploadedFiles() method.
    }

    public function getParsedBody()
    {
        // TODO: Implement getParsedBody() method.
    }

    public function withParsedBody($data)
    {
        // TODO: Implement withParsedBody() method.
    }

    public function getAttributes()
    {
        // TODO: Implement getAttributes() method.
    }

    public function getAttribute($name, $default = null)
    {
        // TODO: Implement getAttribute() method.
    }

    public function withAttribute($name, $value)
    {
        // TODO: Implement withAttribute() method.
    }

    public function withoutAttribute($name)
    {
        // TODO: Implement withoutAttribute() method.
    }
}