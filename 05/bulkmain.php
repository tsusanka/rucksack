#!/usr/bin/env php
<?php

$source = 'data/generated-18/';

$mode = 1;
$anDef = 0.94;
$eqDef = 25;
$startDef = 1000; //3
$endDef = 0.1;

$annealing = [0.5, 0.75, 0.85, 0.9, 0.95, 0.97, 0.99];
$eq = [5, 10, 15, 20, 25, 50, 100];
$startTemps = [5, 10, 20, 50, 100, 1000, 5000];

echo "Ochlazování;Chyba [%];Počet kroků\n";
foreach ($annealing as $a) {
	echo "$a;";
	passthru("hhvm ./main.php $source $mode $a $eqDef $startDef $endDef");
}

echo "Equilibrium;Chyba [%];Počet kroků\n";
foreach ($eq as $e) {
	echo "$e;";
	passthru("hhvm ./main.php $source $mode $anDef $e $startDef $endDef");
}

echo "Počáteční teplota;Chyba [%];Počet kroků\n";
foreach ($startTemps as $s) {
	echo "$s;";
	passthru("hhvm ./main.php $source $mode $anDef $eqDef $s $endDef");
}


function de(...$args)
{
	var_dump(...$args);
	exit;
}
