<?php

namespace Sat;

require_once('loader.php');


abstract class SatSolver
{

	/** @var int */
	protected $varCount;

	/** @var int */
	protected $clauseCount;

	/** @var int */
	protected $maxPrice;

	/** @var int[] */
	protected $solution;

	/** @var int[] */
	protected $weights;

	/** @var [][] */
	protected $clauses;


	/**
	 * SatSolver constructor.
	 * @param $varCount
	 * @param $clauseCount
	 * @param $weights
	 * @param $clauses
	 */
	public function __construct($varCount, $clauseCount, $weights, $clauses)
	{
		$this->varCount = (int)$varCount;
		$this->clauseCount = (int)$clauseCount;
		$this->weights = $weights;
		$this->clauses = $clauses;
		$this->maxPrice = 0;
	}


	abstract public function solve();


	protected function enumerate($values)
	{
		$result = 0;
		foreach ($values as $key => $value) {
			$result += $value * $this->weights[$key];
		}
		return $result;
	}


	protected function evaluate($values)
	{
		$result = 1;
		foreach ($this->clauses as $clause) {
			$clauseResult = 0;
			foreach ($clause as $place) {
				$x = $values[abs($place) - 1];
				if ($place < 0) {
					$x = !$x;
				}
				$clauseResult |= $x;
			}
			$result &= $clauseResult;
		}
		return (bool)$result;
	}


	public function printSolution()
	{
		echo "-----------------------\n";
		echo "max: " . $this->maxPrice . "\nvector: ";
		foreach ($this->solution as $s) {
			echo $s . " ";
		}
		echo "\n";
	}

}
