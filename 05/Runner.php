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

		$clauses = [];
		while (($line = fgets($handle)) !== FALSE) {
			$line = rtrim($line, "\r\n");
			if (substr($line, 0, 1) === 'c') {
				continue;

			} else if (substr($line, 0, 1) === 'p') {
				$exploded = explode(' ', $line);
				$varCount = $exploded[2];
				$clauseCount = $exploded[3];

			} else if (substr($line, 0, 1) === 'w') {
				$exploded = explode(' ', $line);
				array_shift($exploded);
				$weights = $exploded;
			} else {
				$clause = explode(' ', $line);
				array_pop($clause); // removes 0
				$clauses[] = $clause;
			}
		}
		echo "variable count: $varCount \n";
		echo "clause count: $clauseCount \n";
		echo "weights: " . implode(' ', $weights) . "\n";

		$solver = new SatSolver($varCount, $clauseCount, $weights, $clauses);
		$solver->solve();

		fclose($handle);
	}


	private function convertToOnes($clauses, $varCount)
	{
		$new = $now = [];
		foreach ($clauses as $clause) {
			for ($i = 0; $i < $varCount; $i++) {
				$now[$i] = 0;
			}
			foreach ($clause as $variable) {
				$now[abs($variable) - 1] = $variable / abs($variable);
			}
			$new[] = $now;
		}
		return $new;
	}

}
