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


	private function run($arguments, $extra = NULL)
	{
		$solver = new Solver($arguments, $extra);
//		$solver->solve();
//		return [$solver->getSolution(), $solver->getSteps()];
	}


	public function loadFile($source, $expected, $extra = NULL)
	{
		$handle = fopen($source, 'r');
		$handleSolution = fopen($expected, 'r');
		if (!$handle || !$handleSolution) {
			throw new Exception("Provided file does not exist");
		}

		while (($line = fgets($handle)) !== FALSE) {
//			$parameters = rtrim($line, "\r\n");
//			exit;
			echo $line;

//			list($actual, $steps) =
//			if (!$this->steps) {
//				$this->steps = (int)$steps;
//			}
//			$expected = fgets($handleSolution);
//			$this->compareTwoResults($actual, $expected);
		}
		fclose($handle);
		fclose($handleSolution);
	}

}
