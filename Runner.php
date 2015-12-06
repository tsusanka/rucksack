<?php
require_once('loader.php');


class Runner
{

	private function run($class, $arguments, $extra = NULL)
	{
		$solver = new $class($arguments, $extra);
		$solver->solve();
		return $solver->getSolution();
	}


	public function loadFile($class, $source, $expected, $extra = NULL)
	{
		$handle = fopen($source, 'r');
		$handleSolution = fopen($expected, 'r');
		if (!$handle || !$handleSolution) {
			throw new Exception("Provided file does not exist");
		}

		while (($line = fgets($handle)) !== FALSE) {
			if (!$line) continue;
			$parameters = rtrim($line, "\r\n");
			$this->run($class, explode(' ', $parameters), $extra);
		}
		fclose($handle);
		fclose($handleSolution);
	}

}
