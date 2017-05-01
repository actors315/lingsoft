<?php

/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/4/30
 * Time: 21:22
 */

/**
 * xhprof性能分析
 *
 * 需要安装[xhprof](https://github.com/phacility/xhprof)扩展，
 * xhprof不支持php7,可以安装phpng-xhprof(https://github.com/yaoguais/phpng-xhprof)替代
 */

namespace lingyin\profile\drivers;

class Xhprof
{
    public function start()
    {
        $flags = XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY;
        if (defined('PHP_PROFILE_FLAGS_NO_INTERNALS')) {
            $flags += XHPROFFLAGSNO_BUILTINS;
        }
        xhprof_enable($flags);
    }

    public function stop()
    {
        return xhprof_disable();
    }
}