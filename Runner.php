<?php
require_once('loader.php');


class Runner
{

	/** @var int[] */
	private $errors;

	/** @var int */
	private $steps = 0;


	private function run($arguments, $extra = NULL)
	{
		$solver = new RuckSackProblemAnnealing($arguments, $extra);
		$solver->solve();
		return [$solver->getSolution(), $solver->getSteps()];
	}


	public function loadFile($source, $expected, $extra = NULL)
	{
		$handle = fopen($source, 'r');
		$handleSolution = fopen($expected, 'r');
		if (!$handle || !$handleSolution) {
			throw new Exception("Provided file does not exist");
		}

		while (($line = fgets($handle)) !== FALSE) {
			$parameters = rtrim($line, "\r\n");
			list($actual, $steps) = $this->run(explode(' ', $parameters), $extra);
			if (!$this->steps) {
				$this->steps = (int)$steps;
			}
			$expected = fgets($handleSolution);
			$this->compareTwoResults($actual, $expected);
		}
		fclose($handle);
		fclose($handleSolution);
	}


	private function compareTwoResults($actual, $expected)
	{
		if ($actual === $expected) {
			$this->errors[] = 0;
			return;
		}
		$args = explode(" ", $actual);
		$priceActual = $args[2];
		$args = explode(" ", $expected);
		$priceExpected = $args[2];

		$relativeError = (abs($priceExpected - $priceActual)) / $priceExpected;
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

}
