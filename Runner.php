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


	public function loadFile($source, $solution, $extra= NULL)
	{
		$handle = fopen($source, 'r');
		$handleSolution = fopen($solution, 'r');
		if (!$handle || !$handleSolution) {
			throw new Exception("Provided file does not exist");
		}

		while (($line = fgets($handle)) !== FALSE) {
			$parameters = rtrim($line, "\r\n");
			$result = $this->run(explode(' ', $parameters), $extra);
			$solution = fgets($handleSolution);
			$this->compareTwoResults($result, $solution);
		}
		fclose($handle);
		fclose($handleSolution);
	}


	private function compareTwoResults($a, $b)
	{
		if ($a === $b) {
			$this->errors[] = 0;
			return;
		}
		$args = explode(" ", $a);
		$priceA = $args[2];
		$args = explode(" ", $b);
		$priceB = $args[2];
		$this->errors[] = abs($priceA - $priceB);
	}


	public function getErrorRate()
	{
		return array_sum($this->errors) / count($this->errors);
	}

}
