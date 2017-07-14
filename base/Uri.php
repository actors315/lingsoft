<?php
/**
 * Created by PhpStorm.
 * User: xiehuanjin
 * Date: 2017/7/14
 * Time: 11:13
 */

namespace lingyin\base;


abstract class Uri extends Component implements UriInterface
{
    public $protocol;
    protected $_path;

    public function setPath($path)
    {
        $this->_path = $path;
    }

    public function getPath()
    {
        return $this->_path;
    }

    abstract protected function detectPath();
}