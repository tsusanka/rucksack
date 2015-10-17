#!/usr/bin/env php
<?php
require_once('loader.php');

if (!isset($argv[1])) {
	echo "Missing filename\n";
	exit(1);
}

loadFile($argv[1]);

function loadFile($filename)
{
	$handle = fopen($filename, 'r');
	if ($handle) {
		while (($line = fgets($handle)) !== FALSE) {
			$parameters = rtrim($line, "\r\n");
			$r = new RuckSackProblemBrute(explode(' ', $parameters));
			$r->solve();
		}

		fclose($handle);
	} else {
		echo "Provided file does not exist\n";
		exit(2);
	}
}

function de($args)
{
	var_dump($args);
	exit;
}
