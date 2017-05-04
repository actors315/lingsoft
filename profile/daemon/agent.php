<?php
/**
 * php-logstash base configure
 */
require __DIR__ .'/php-logstash/logstash.php';
$cfg = [
	'redis' => 'tcp://username:profileLogStash@115.29.49.123:6380',
];


(new LogStash())->handler($cfg)->run();
