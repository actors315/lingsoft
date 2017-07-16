<?php
/**
 * Created by PhpStorm.
 * User: xiehuanjin
 * Date: 2017/7/14
 * Time: 11:17
 */

namespace lingyin\web\http;


use Psr\Http\Message\UriInterface;

class Uri extends \lingyin\base\Uri implements UriInterface
{

    public function init()
    {
        $this->setPath($this->detectPath());
    }

    protected function detectPath()
    {
        switch ($this->protocol) {
            case 'REQUEST_URI' :
                $path = $this->_parse_request_uri();
                break;
            case 'QUERY_STRING' :
                $path = $this->_parse_query_string();
                break;
            case 'PATH_INFO' :
            default :
                $path = isset($_SERVER[$this->protocol]) ? $_SERVER[$this->protocol] : $this->_parse_request_uri();
        }
        return $path;
    }

    protected function _parse_request_uri()
    {
        if (!isset($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME'])) {
            return '';
        }

        $uri = parse_url('http://dummy' . $_SERVER['REQUEST_URI']);
        $query = isset($uri['query']) ? $uri['query'] : '';
        $uri = isset($uri['path']) ? $uri['path'] : '';

        if (isset($_SERVER['SCRIPT_NAME'][0])) {
            if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0) {
                $uri = (string)substr($uri, strlen($_SERVER['SCRIPT_NAME']));
            } elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0) {
                $uri = (string)substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
            }
        }

        // This section ensures that even on servers that require the URI to be in the query string (Nginx) a correct
        // URI is found, and also fixes the QUERY_STRING server var and $_GET array.
        if (trim($uri, '/') === '' && strncmp($query, '/', 1) === 0) {
            $query = explode('?', $query, 2);
            $uri = $query[0];
            $_SERVER['QUERY_STRING'] = isset($query[1]) ? $query[1] : '';
        } else {
            $_SERVER['QUERY_STRING'] = $query;
        }

        parse_str($_SERVER['QUERY_STRING'], $_GET);

        if (trim($uri, '/') === '') {
            return '';
        }

        return $this->_remove_relative_directory($uri);

    }

    protected function _parse_query_string()
    {
        $uri = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : @getenv('QUERY_STRING');
        if (trim($uri, '/') === '') {
            return '';
        } elseif (strcmp($uri, '/', 1) === 0) {
            $uri = explode('?', $uri, 2);
            $_SERVER['QUERY_STRING'] = isset($uri[1]) ? $uri[1] : '';
            $uri = $uri[0];
        }
        parse_str($_SERVER['QUERY_STRING'], $_GET);

        return $this->_remove_relative_directory($uri);
    }

    /**
     * 去除uri中的相对定位
     *
     * @param $uri
     * @return string
     */
    protected function _remove_relative_directory($uri)
    {
        $uris = array();
        $tok = strtok($uri, '/');
        while ($tok !== FALSE) {
            if ((!empty($tok) OR $tok === '0') && $tok !== '..') {
                $uris[] = $tok;
            }
            $tok = strtok('/');
        }

        return implode('/', $uris);
    }

    public function getScheme()
    {
        // TODO: Implement getScheme() method.
    }

    public function getAuthority()
    {
        // TODO: Implement getAuthority() method.
    }

    public function getUserInfo()
    {
        // TODO: Implement getUserInfo() method.
    }

    public function getHost()
    {
        // TODO: Implement getHost() method.
    }

    public function getPort()
    {
        // TODO: Implement getPort() method.
    }

    public function getQuery()
    {
        // TODO: Implement getQuery() method.
    }

    public function getFragment()
    {
        // TODO: Implement getFragment() method.
    }

    public function withScheme($scheme)
    {
        // TODO: Implement withScheme() method.
    }

    public function withUserInfo($user, $password = null)
    {
        // TODO: Implement withUserInfo() method.
    }

    public function withHost($host)
    {
        // TODO: Implement withHost() method.
    }

    public function withPort($port)
    {
        // TODO: Implement withPort() method.
    }

    public function withPath($path)
    {
        // TODO: Implement withPath() method.
    }

    public function withQuery($query)
    {
        // TODO: Implement withQuery() method.
    }

    public function withFragment($fragment)
    {
        // TODO: Implement withFragment() method.
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
    }
}