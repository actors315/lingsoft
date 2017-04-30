<?php

/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/4/30
 * Time: 21:22
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