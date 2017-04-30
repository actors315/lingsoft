<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/4/30
 * Time: 21:20
 */

namespace lingyin\profile;
use lingyin\profile\drivers\Xhprof;
use lingyin\profile\drivers\Uprofiler;

/**
 * xhprof性能分析
 *
 * 需安装相应扩展，支持Xhprof和Uprofiler
 */

class Profile
{

    /**
     * 目前支持的extension
     *
     * @var array
     */
    protected static $_valid_drivers = [
        'Xhprof' => 'xhprof',
        'Uprofiler' => 'uprofiler'
    ];

    /**
     * @var string 可通过`$_GET`或者`$_COOKIE`触发性能分析的变量名称
     */
    const TRIGGER_NAME = 'lingyin-profile';
    /**
     * 采样率
     *
     * 值越小，采样率越高.如果定义了常量`PHP_PROFILE_SAMPLING_RATE`，则取该常量值
     *
     * @var int
     */
    const SAMPLING_RATE = 10;

    /**
     * 站点标识
     *
     * 通过定义常量`PHP_PROFILE_SITE`修改该取
     */
    const SITE = 'test-profile';

    /**
     * @var bool 是否采集样本
     */
    private static $_started = false;

    private static $_adapter = 'Xhprof';

    private static $_driver = null;

    /**
     * 开始分析
     *
     * @param $config
     * @return boolean
     */
    public static function start($config = [])
    {
        isset($config['adapter']) && self::$_adapter = $config['adapter'];

        if (!self::isSupported(self::$_adapter)) {
            return false;
        } elseif (self::$_started) {
            return true;
        } elseif (isset($_GET[self::TRIGGER_NAME])) {
            setcookie(self::TRIGGER_NAME, 1);
            self::$_started = true;
        } elseif (isset($_COOKIE[self::TRIGGER_NAME]) || self::isSampling()) {
            self::$_started = true;
        }

        if (self::$_started) {
            self::$_driver->start();
            register_shutdown_function(__CLASS__ . '::stop');
        }
        return self::$_started;
    }

    /**
     * 结束分析
     *
     * @return mixed
     */
    public static function stop()
    {

        if (!self::$_started) {
            return;
        }
        $data = [
            'request_id' => uniqid() . '-' . rand(1000, 9999),
            'time' => time(),
            'group_url' => self::getGroupUrl(),
            'ip' => yii::$app->request->getUserIp(),
            'exec_time' => round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 6),
            'site' => defined('PHP_PROFILE_SITE') ? PHP_PROFILE_SITE : self::SITE,
            'profile' => self::$_driver->stop(),
            'extra' => [
                'SERVER' => $_SERVER,
            ],
        ];
        self::save($data);

        return $data;
    }

    /**
     * 是否采样？
     *
     * @return bool
     */
    private static function isSampling()
    {
        if (defined('PHP_PROFILE_SAMPLING_RATE')) {
            return 1 == rand(1, PHP_PROFILE_SAMPLING_RATE);
        } else {
            return 1 == rand(1, self::SAMPLING_RATE);
        }
    }

    /**
     * 获取当前url所属的分组url
     *
     * 在性能分析中可查看该分组的所有性能数据
     *
     * @return string
     */
    private static function getGroupUrl()
    {
        return '';
    }

    /**
     * 保存性能数据
     *
     * @param array $data
     */
    private static function save(array $data)
    {
        if (defined('PHP_PROFILE_OUTPUT')) {
            $path = PHP_PROFILE_OUTPUT;
        } elseif (YII_DEBUG) {
            $path = __DIR__ . '/../runtime/logs/profile';
        } else {
            $path = dirname(ini_get('error_log'));
        }
        if (!is_dir($path)) {
            mkdir($path, 0770, true);
        }

        $file = $path . '/profile.dat';
        // 大于100M时，清空
        if (is_file($file) && filesize($file) > 104857600) {
            file_put_contents($file, '');
        }
        file_put_contents($file, serialize($data) . "\n", FILE_APPEND);
        self::saveByDev($data);
    }

    /**
     * 开发环境下保存性能数据
     *
     * @param array $data
     */
    private static function saveByDev(array $data)
    {
        if (false) {//YII_DEBUG
            return;
        } elseif (defined('PHP_PROFILE_API')) {
            $url = PHP_PROFILE_API;
        } else {
            $url = 'http://profile.lingyin99.com/api/import';
        }
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => ['data' => gzcompress(serialize($data))],
            CURLOPT_TIMEOUT => 3,
            CURLOPT_CONNECTTIMEOUT => 3,
        ]);
        curl_exec($ch);
        curl_close($ch);
    }

    private static function isSupported($driver)
    {
        if (!isset(self::$_valid_drivers[$driver])) {
            return false;
        }

        if (!extension_loaded(self::$_valid_drivers[$driver])) {
            return false;
        }

        self::$_driver = new $driver;

        return true;
    }
}