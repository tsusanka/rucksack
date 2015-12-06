#!/usr/bin/env php
<?php
require_once('loader.php');

if (!isset($argv[1])) {
	echo "Missing filename\n";
	exit(1);
}
if (!isset($argv[2])) {
	echo "Missing solution filename\n";
	exit(1);
}
if (!isset($argv[3])) {
	echo "Missing ruck sack class name \n";
	exit(1);
}

if (!in_array($argv[3], ['RuckSackProblemBB', 'RuckSackProblemDynamic', 'RuckSackProblemRatio'])) {
	echo "Such class not whitelisted \n";
	exit(1);
}


$runner = new Runner();
try {
	$runner->loadFile($argv[3], $argv[1], $argv[2]);
} catch (Exception $e) {
	echo $e->getMessage();
	exit(2);
}

function de(...$args)
{
	var_dump(...$args);
	exit;
}
