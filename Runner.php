<?php
require_once('loader.php');


class Runner
{

	/** @var float[] */
	private $errors;


	private function run($arguments)
	{
		$brute = new RuckSackProblemBrute($arguments);
		$optimalPrice = $brute->solve();
		$ratio = new RuckSackProblemRatio($arguments);
		$heuresticPrice = $ratio->solve();
		$this->errors[] = $this->getRelativeError($optimalPrice, $heuresticPrice);
	}


	public function loadFile($filename)
	{
		$handle = fopen($filename, 'r');
		if ($handle) {
			while (($line = fgets($handle)) !== FALSE) {
				$parameters = rtrim($line, "\r\n");
				$this->run(explode(' ', $parameters));
			}
			fclose($handle);
		} else {
			throw new Exception("Provided file does not exist");
		}
	}


	public function getRelativeErrorAverage()
	{
		return array_sum($this->errors) / count($this->errors);
	}


	public function getRelativeErrorMax()
	{
		return max($this->errors);
	}


	private function getRelativeError($optimal, $heurestic)
	{
		return ($optimal - $heurestic) / $optimal;
	}

}
