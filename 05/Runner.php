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

	/** @var int */
	private $foundOptimal = 0;


	public function loadFiles($dir, $extra)
	{
		$files = array_diff(scandir($dir), array('..', '.'));
		$a = 0;
		foreach ($files as $file) {
			$this->loadFile($dir . '/' . $file, $extra);
			if ($a++ == 5) break;
		}
//		$this->loadFile($dir, $extra);
	}


	public function loadFile($source, $extra)
	{
		$handle = fopen($source, 'r');
		if (!$handle) {
			throw new Exception("Provided file does not exist");
		}

		$clauseCountCheck = $clauseCount = $varCount = $weights = $theirPrice = 0;
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
				$theirPrice = (int) $exploded[1];

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

		$solver = new SatSolverAnnealing($varCount, $clauseCount, $weights, $clauses, $extra);
		list($myPrice, $steps) = $solver->solve();
		$this->steps = $steps;
		$this->compareTwoResults($myPrice, $theirPrice);

		echo end(explode("/", $source)) . " mine: " . $myPrice . " their: " . $theirPrice . " steps: $steps \n";

		fclose($handle);
	}

	private function compareTwoResults($mine, $theirs)
	{
		if ($mine === $theirs) {
			$this->foundOptimal++;
			$this->errors[] = 0;
			return;
		}
		$relativeError = (abs($theirs - $mine)) / $theirs;
		$this->errors[] = $relativeError;
	}

	public function getErrorRate()
	{
		return array_sum($this->errors) / count($this->errors) * 100;
	}

	public function getSteps()
	{
		return $this->steps;
	}

	public function getFoundOptimal()
	{
		return $this->foundOptimal;
	}

}
