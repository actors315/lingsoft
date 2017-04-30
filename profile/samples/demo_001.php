<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/4/30
 * Time: 21:58
 */

include_once dirname(__FILE__).'/../Profile.php';
function bar() {
    return 1;
}
function foo($x) {
    $sum = 0;
    for ($idx = 0; $idx < 2; $idx++) {
        $sum += bar();
    }
    return strlen("hello: {$x}");
}
\lingyin\profile\Profile::start(['adapter'=>'Xhprof']);
foo(10);
print_r(\lingyin\profile\Profile::stop());