#!/usr/bin/env php
<?php

$sources = [
	4 => 'data/input/knap_4.inst.dat',
	10 => 'data/input/knap_10.inst.dat',
	20 => 'data/input/knap_20.inst.dat',
	25 => 'data/input/knap_25.inst.dat',
	30 => 'data/input/knap_30.inst.dat',
];

$solutions = [
	4 => 'data/output/knap_4.sol.dat',
	10 => 'data/output/knap_10.sol.dat',
	20 => 'data/output/knap_20.sol.dat',
	25 => 'data/output/knap_25.sol.dat',
	30 => 'data/output/knap_30.sol.dat',
];

foreach ([4, 10, 20, 25, 30] as $size) {
	echo "n=$size eps=0.2 errRate=";
	passthru('time ./main.php ' . $sources[$size] . " " . $solutions[$size]);
	exit;
}

function de(...$args)
{
	var_dump(...$args);
	exit;
}
