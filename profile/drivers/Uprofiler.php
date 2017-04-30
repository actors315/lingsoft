<?php

/**
 * xhprof性能分析
 *
 * 需要安装[uprofiler](https://github.com/FriendsOfPHP/uprofiler)扩展，
 * 原xhprof不能很好的兼容php5.6
 */
namespace lingyin\profile\drivers;

class Uprofiler
{

    public static function start()
    {
        $flags = UPROFILER_FLAGS_CPU + UPROFILER_FLAGS_MEMORY;
        if (defined('PHP_PROFILE_FLAGS_NO_INTERNALS')) {
            $flags += PHP_PROFILE_FLAGS_NO_INTERNALS;
        }
        uprofiler_enable($flags);
    }

    public static function stop()
    {
        return uprofiler_disable();
    }

}