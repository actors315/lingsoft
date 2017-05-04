<?php

require __DIR__ .'/LogSync.php';
require __DIR__.'/channel/SyncInterface.php';
require __DIR__ .'/channel/Redis.php';
$cfg = [

];

(new \lingyin\profile\daemon\LogSync())->handler($cfg)->run();
