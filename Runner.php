<?php
require_once('loader.php');


class Runner
{

	/** @var int[] */
	private $errors;


	private function run($arguments, $extra = NULL)
	{
		$solver = new RuckSackProblemFPTAS($arguments, $extra);
		$solver->solve();
		return $solver->getSolution();
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
			$actual = $this->run(explode(' ', $parameters), $extra);
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
		return max($this->errors) * 100;
	}

}
