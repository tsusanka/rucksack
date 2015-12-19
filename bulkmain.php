#!/usr/bin/env php
<?php

$source = 'data/input/knap_40.inst.dat';
$solution = 'data/output/knap_40.sol.dat';

$anDef = 0.94;
$eqDef = 5;
$startDef = 20; //3
$endDef = 0.1;


$annealing = [0.1, 0.3, 0.5, 0.75, 0.85, 0.9, 0.93, 0.95, 0.97, 0.99];
$eq = [1, 2, 3, 5, 10, 15, 20, 30, 40];
$startTemps = [0.2, 0.5, 2, 5, 10, 20, 40, 70, 100];

echo "Ochlazování;Chyba [%];Počet kroků\n";
foreach ($annealing as $a) {
	echo "$a;";
	passthru('./main.php ' . $source . " " . $solution . " $a $eqDef $startDef $endDef");
}

echo "Equilibrium;Chyba [%];Počet kroků\n";
foreach ($eq as $e) {
	echo "$e;";
	passthru('./main.php ' . $source . " " . $solution . " $anDef $e $startDef $endDef");
}

echo "Počáteční teplota;Chyba [%];Počet kroků\n";
foreach ($startTemps as $s) {
	echo "$s;";
	passthru('./main.php ' . $source . " " . $solution . " $anDef $eqDef $s $endDef");
}


function de(...$args)
{
	var_dump(...$args);
	exit;
}
