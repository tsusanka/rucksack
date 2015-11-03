#!/usr/bin/env php
<?php
require_once('loader.php');

if (!isset($argv[1])) {
	echo "Missing filename\n";
	exit(1);
}

$runner = new Runner();
try {
	$runner->loadFile($argv[1]);
} catch (Exception $e) {
	echo $e->getMessage();
	exit(2);
}

function de(...$args)
{
	var_dump(...$args);
	exit;
}
