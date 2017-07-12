<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/7/12
 * Time: 21:19
 */

/**
 * 入口文件
 */

defined('ENVIRONMENT') || define('ENVIRONMENT', empty($_SERVER['ENV']) ? 'product' : $_SERVER['ENV']);
switch (ENVIRONMENT) {
    case 'dev' :
        error_reporting(-1);
        ini_set('display_errors', 1);
        break;

    case 'test' :
    case 'product' :
        ini_set('display_errors', 0);
        if (version_compare(PHP_VERSION, '5.3', '>=')) {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        } else {
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
        }
        break;
    default :
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1);
}

require(__DIR__ . '/../base/Ling.php');
spl_autoload_register(['\lingyin\base\Ling', 'autoload'], true, true);

$config = \lingyin\base\Ling::loadConfig(__DIR__ . '/../config/web.php');
return $config;