#!/usr/bin/env php
<?php

namespace Sat;

require_once('loader.php');


if (!isset($argv[1])) {
	echo "Missing filename\n";
	exit(1);
}
if (!(isset($argv[2]) || isset($argv[3]) || isset($argv[4]) || isset($argv[5]) || isset($argv[6]))) {
	echo "Missing annealing parameters\n";
	exit(3);
}

$runner = new Runner();
try {
	$runner->loadFiles($argv[1], [$argv[2], $argv[3], $argv[4], $argv[5], $argv[6]]);
} catch (\Exception $e) {
	echo $e->getMessage();
	exit(2);
}

//echo "steps;foundOptimal;error\n";
echo round($runner->getErrorRate(), 2) . ";" . $runner->getSteps() . "\n";

function de(...$args)
{
	var_dump(...$args);
	exit;
}
