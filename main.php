#!/usr/bin/env php
<?php

require_once('RuckSackProblem.php');

// id, n, M, ...
$rucksack = new RuckSackProblem(9000, 4, 100, [18, 114, 42, 136, 88, 192, 3, 223]);
$rucksack->solve();
exit(0);

$data = file_get_contents('data/knap_4.inst.dat');

if (!isset($argv[1])) {
	echo "Missing filename\n";
	exit(1);
}

function loadFile($filename)
{
	$handle = fopen($filename, 'r');
	if ($handle) {
		while (($line = fgets($handle)) !== FALSE) {
			$exploded = explode(' ', $line);
			//		new RuckSackProblem($exploded[0], $exploded[1], $exploded[2], $exploded[3])
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
