#!/usr/bin/env php
<?php

$source = 'data/input/';

$anDef = 0.94;
$eqDef = 5;
$startDef = 20;
$endDef = 0.1;


echo "Metoda 1\n";

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
