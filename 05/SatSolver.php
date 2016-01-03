<?php

namespace Sat;

require_once('loader.php');


class SatSolver
{

	/** @var int */
	private $varCount;

	/** @var int */
	private $clauseCount;

	/** @var int[] */
	private $weights;

	/** @var [][] */
	private $clauses;


	/**
	 * SatSolver constructor.
	 * @param $varCount
	 * @param $clauseCount
	 * @param $weights
	 * @param $clauses
	 */
	public function __construct($varCount, $clauseCount, $weights, $clauses)
	{
		$this->varCount = $varCount;
		$this->clauseCount = $clauseCount;
		$this->weights = $weights;
		$this->clauses = $clauses;
	}


	public function solve()
	{
		$values = [1, 1, 1, 0];
		echo $this->evaluate($values) . "\n";
		echo $this->enumerate($values) . "\n";
	}


	private function enumerate($values)
	{
		$result = 0;
		foreach ($values as $key => $value) {
			$result += $value * $this->weights[$key];
		}
		return $result;
	}


	private function evaluate($values)
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
		return $result;
	}

}
