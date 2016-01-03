<?php

namespace Sat;

require_once('loader.php');


class SatSolver
{

	/** @var int */
	private $varCount;

	/** @var int */
	private $clauseCount;

	/** @var int */
	private $maxPrice;

	/** @var int[] */
	private $solution;

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
		$this->varCount = (int)$varCount;
		$this->clauseCount = (int)$clauseCount;
		$this->weights = $weights;
		$this->clauses = $clauses;
		$this->maxPrice = 0;
	}


	public function solve()
	{
		$this->brute();
		$this->printSolution();
	}


	private function brute()
	{
		$values = [];
		for ($i = 0; $i < $this->varCount; $i++) {
			$values[] = 0;
		}
		$this->check($values);
		$this->walk(0, $values);
	}


	public function walk($index, $values)
	{
		if ($index === $this->varCount) {
			return $values;
		}

		$this->walk($index + 1, $values);
		$values[$index] = !$values[$index];

		$this->check($values);

		$this->walk($index + 1, $values);
	}


	private function check($values)
	{
		if ($this->evaluate($values)) {
			$price = $this->enumerate($values);
			if ($price > $this->maxPrice) {
				$this->maxPrice = $price;
				$this->solution = $values;
			}
		}
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
		return (bool)$result;
	}


	private function printSolution()
	{
		echo "-----------------------\n";
		echo "max: " . $this->maxPrice . "\nvector: ";
		foreach ($this->solution as $s) {
			echo $s . " ";
		}
		echo "\n";
	}

}
