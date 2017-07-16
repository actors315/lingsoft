<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/7/13
 * Time: 22:43
 */

namespace lingyin\web\router;

use Aura\Router\Matcher;
use Aura\Router\RouterContainer;

class Route extends \lingyin\base\Route
{

    private $_routerContainer;

    public $matcher;

    public function init()
    {
        $this->_routerContainer = new RouterContainer();
        $map = $this->_routerContainer->getMap();
        foreach ($this->rules as $key => $value) {
            if (is_string($value)) {
                $map->route($key, $value);
            } elseif (is_array($value) && isset($value['path'])) {
                $path = $value['path'];
                $method = isset($value['method']) ? $value['method'] : 'route';
                $route = $map->{$method}($key, $path);
                (isset($value['tokens']) && is_array($value['tokens']))&& $route->tokens($value['tokens']);
                (isset($value['defaults']) && is_array($value['defaults'])) && $route->defaults($value['defaults']);
            }
        }
        $this->matcher = $this->_routerContainer->getMatcher();
    }

    /**
     * @return Matcher
     */
    public function getMatcher()
    {
        return $this->matcher;
    }
}