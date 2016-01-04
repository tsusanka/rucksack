#!/usr/bin/env php
<?php

$source = 'data/input/';

$modes = [1, 2, 3, 4];
$values = [
	[0.95, 100, 100, 0.1],
//	[0.95, 250, 20, 0.1],
];

foreach ($modes as $mode) {
	echo "Mode $mode\n";
	foreach ($values as $args) {
		echo implode(';', $args) . "\n";
		passthru("hhvm ./main.php data/input $mode " . implode(' ', $args));
	}
}


function de(...$args)
{
	var_dump(...$args);
	exit;
}
