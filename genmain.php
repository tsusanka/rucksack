#!/usr/bin/env php
<?php

$classes = ['RuckSackProblemBB', 'RuckSackProblemRatio', 'RuckSackProblemDynamic'];
$maxWeight = [25, 50, 75, 100, 250, 500];
$maxPrice = [25, 50, 75, 100, 250, 500];
$ratios = [0.1, 0.2, 0.4, 0.6, 0.8, 1];
$gran = [0.1, 0.2, 0.4, 0.6, 0.8, 1];
$sizes = [-1, 0, 1];

echo "Max weight;$classes[0];$classes[1];$classes[2]\n";
foreach ($maxWeight as $weight) {
	echo "$weight;";
	foreach ($classes as $class) {
		passthru("knapgen/knapgen.o -n 16 -N 50 -m 0.6 -W $weight -C 250 -k 1 -d 0 > input.txt 2> output.txt");
		if ($class === RuckSackProblemBB::class) {
			passthru("./main.php input.txt output.txt $class > solution.txt");
			echo parseSteps() . ";";
		} elseif ($class === RuckSackProblemDynamic::class) {
			passthru("rm -rf solution.txt");
			passthru("./main.php input.txt output.txt $class > solution.txt");
			echo parseSteps() . ";";
		} elseif ($class === RuckSackProblemRatio::class) {
			passthru("./main.php input.txt output.txt $class > ratio.txt");
			echo parseHeurestic() . ";";
		}
		passthru("rm -rf input.txt");
		passthru("rm -rf output.txt");
	}
	passthru("rm -rf solution.txt");
	passthru("rm -rf ratio.txt");
	echo "\n";
}

echo "Max price;$classes[0];$classes[1];$classes[2]\n";
foreach ($maxPrice as $price) {
	echo "$price;";
	foreach ($classes as $class) {
		passthru("knapgen/knapgen.o -n 16 -N 50 -m 0.6 -W 100 -C $price -k 1 -d 0 > input.txt 2> output.txt");
		if ($class === RuckSackProblemBB::class) {
			passthru("./main.php input.txt output.txt $class > solution.txt");
			echo parseSteps() . ";";
		} elseif ($class === RuckSackProblemDynamic::class) {
			passthru("rm -rf solution.txt");
			passthru("./main.php input.txt output.txt $class > solution.txt");
			echo parseSteps() . ";";
		} elseif ($class === RuckSackProblemRatio::class) {
			passthru("./main.php input.txt output.txt $class > ratio.txt");
			echo parseHeurestic() . ";";
		}
		passthru("rm -rf input.txt");
		passthru("rm -rf output.txt");
	}
	passthru("rm -rf solution.txt");
	passthru("rm -rf ratio.txt");
	echo "\n";
}

echo "ratio;$classes[0];$classes[1];$classes[2]\n";
foreach ($ratios as $ratio) {
	echo "$ratio;";
	foreach ($classes as $class) {
		passthru("knapgen/knapgen.o -n 16 -N 50 -m $ratio -W 100 -C 250 -k 1 -d 0 > input.txt 2> output.txt");
		if ($class === RuckSackProblemBB::class) {
			passthru("./main.php input.txt output.txt $class > solution.txt");
			echo parseSteps() . ";";
		} elseif ($class === RuckSackProblemDynamic::class) {
			passthru("rm -rf solution.txt");
			passthru("./main.php input.txt output.txt $class > solution.txt");
			echo parseSteps() . ";";
		} elseif ($class === RuckSackProblemRatio::class) {
			passthru("./main.php input.txt output.txt $class > ratio.txt");
			echo parseHeurestic() . ";";
		}
		passthru("rm -rf input.txt");
		passthru("rm -rf output.txt");
	}
	passthru("rm -rf solution.txt");
	passthru("rm -rf ratio.txt");
	echo "\n";
}

echo "gran;$classes[0];$classes[1];$classes[2]\n";
foreach ($gran as $g) {
	echo "$g (d=-1);";
	foreach ($classes as $class) {
		passthru("knapgen/knapgen.o -n 16 -N 50 -m 0.6 -W 100 -C 250 -k $g -d -1 > input.txt 2> output.txt");
		if ($class === RuckSackProblemBB::class) {
			passthru("./main.php input.txt output.txt $class > solution.txt");
			echo parseSteps() . ";";
		} elseif ($class === RuckSackProblemDynamic::class) {
			passthru("rm -rf solution.txt");
			passthru("./main.php input.txt output.txt $class > solution.txt");
			echo parseSteps() . ";";
		} elseif ($class === RuckSackProblemRatio::class) {
			passthru("./main.php input.txt output.txt $class > ratio.txt");
			echo parseHeurestic() . ";";
		}
		passthru("rm -rf input.txt");
		passthru("rm -rf output.txt");
	}
	passthru("rm -rf solution.txt");
	passthru("rm -rf ratio.txt");
	echo "\n";
}

echo "sizes;$classes[0];$classes[1];$classes[2]\n";
foreach ($gran as $g) {
	echo "$g (d=1);";
	foreach ($classes as $class) {
		passthru("knapgen/knapgen.o -n 16 -N 50 -m 0.6 -W 100 -C 250 -k $g -d 1 > input.txt 2> output.txt");
		if ($class === RuckSackProblemBB::class) {
			passthru("./main.php input.txt output.txt $class > solution.txt");
			echo parseSteps() . ";";
		} elseif ($class === RuckSackProblemDynamic::class) {
			passthru("rm -rf solution.txt");
			passthru("./main.php input.txt output.txt $class > solution.txt");
			echo parseSteps() . ";";
		} elseif ($class === RuckSackProblemRatio::class) {
			passthru("./main.php input.txt output.txt $class > ratio.txt");
			echo parseHeurestic() . ";";
		}
		passthru("rm -rf input.txt");
		passthru("rm -rf output.txt");
	}
	passthru("rm -rf solution.txt");
	passthru("rm -rf ratio.txt");
	echo "\n";
}


function parseSteps()
{
	$steps = [];
	$handle = fopen('solution.txt', 'r');
	while (($line = fgets($handle)) !== FALSE) {
		$exploded = explode('S: ', $line);
		$steps[] = (int)$exploded[1];
	}
	return array_sum($steps);
}


function parseHeurestic()
{
	$handleSolution = fopen('solution.txt', 'r');
	$handle = fopen('ratio.txt', 'r');
	$errors = [];
	while (($line = fgets($handle)) !== FALSE) {
		$expected = fgets($handleSolution);
		$errors[] = compareTwoResults($line, $expected);
	}
	return (array_sum($errors) / 50);
}


function compareTwoResults($actual, $expected)
{
	$expected = explode('S: ', $expected);
	$expected = $expected[0];
	if ($actual === $expected) {
		return 0;
	}
	$args = explode(" ", $actual);
	$priceActual = $args[2];
	$args = explode(" ", $expected);
	$priceExpected = $args[2];

	$relativeError = (abs($priceExpected - $priceActual)) / $priceExpected;
	return $relativeError;
}
