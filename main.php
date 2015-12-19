#!/usr/bin/env php
<?php
require_once('loader.php');

if (!isset($argv[1])) {
	echo "Missing filename\n";
	exit(1);
}
if (!isset($argv[2])) {
	echo "Missing solution filename\n";
	exit(2);
}
if (!(isset($argv[3]) || isset($argv[4]) || isset($argv[5]) || isset($argv[6])))
{
	echo "Missing annealing parameters\n";
	exit(3);
}

$runner = new Runner();
try {
	$runner->loadFile($argv[1], $argv[2], [$argv[3], $argv[4], $argv[5], $argv[6]]);
} catch (Exception $e) {
	echo $e->getMessage();
	exit(2);
}

echo $runner->getErrorRate();

function de(...$args)
{
	var_dump(...$args);
	exit;
}
