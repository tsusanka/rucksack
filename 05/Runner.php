<?php

namespace Sat;

require_once('loader.php');

use Exception;


class Runner
{

	/** @var int[] */
	private $errors;

	/** @var int */
	private $steps = 0;


	public function loadFile($source)
	{
		$handle = fopen($source, 'r');
		if (!$handle) {
			throw new Exception("Provided file does not exist");
		}

		$clauseCountCheck = $clauseCount = $varCount = $weights = $solutionPrice = 0;
		$clauses = [];
		while (($line = fgets($handle)) !== FALSE) {
			$line = rtrim($line, "\r\n");
			$line = rtrim($line, " ");
			$exploded = explode(' ', $line);
			if ($exploded[0] === 'c' || $line === '%') {
				continue;

			} else if ($exploded[0] === 'p') {
				$varCount = (int)$exploded[2];
				$clauseCount = (int)$exploded[3];

			} else if ($exploded[0] === 'w') {
				array_shift($exploded);
				$weights = $exploded;

			} else if ($exploded[0] === 's') {
				$solutionPrice = $exploded[1];

			} else {
				$clauseCountCheck++;
				$clause = explode(' ', $line);
				array_pop($clause); // removes 0
				$clauses[] = $clause;
			}
		}
		if ($clauseCount != $clauseCountCheck) {
			echo "Error: number of clauses specified in the comment do not match the file's row count \n";
			exit(2);
		}

		$solver = new SatSolverAnnealing($varCount, $clauseCount, $weights, $clauses, 0.95, 100, 100, 0.1);
		echo "b: " . $solver->solve() .  " r: " . $solutionPrice . "\n";

		fclose($handle);
	}

}
