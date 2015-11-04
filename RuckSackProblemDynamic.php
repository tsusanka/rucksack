<?php
require_once('loader.php');


class RuckSackProblemDynamic extends BaseRuckSackProblem
{

	/** @const int */
	const INFINITY = PHP_INT_MAX;

	/** @var int */
	private $maxPotentialPrice;

	/** @var int[][] */
	private $table;


	public function solve()
	{
		$this->maxPotentialPrice = array_sum($this->prices);
		$this->initTable();

		for ($i = $this->maxPotentialPrice; $i > 0; $i--) {
			$this->W($this->size, $i);
		}
		$this->retrieveSolution();
	}


	private function initTable()
	{
		for ($i = 0; $i <= $this->size; $i++) {
			for ($y = 0; $y <= $this->maxPotentialPrice; $y++) {
				$this->table[$i][$y] = NULL;
			}
		}
	}


	private function W($i, $c)
	{
		if ($c < 0) return self::INFINITY;
		if ($i === 0 && $c === 0) return 0;
		if ($i === 0) return self::INFINITY;
		if ($this->table[$i][$c] !== NULL) {
			return $this->table[$i][$c];
		}

		$this->table[$i][$c] = min($this->W($i - 1, $c), $this->W($i - 1, $c - $this->getPrice($i)) + $this->getWeight($i));

		return $this->table[$i][$c];
	}


	public function retrieveSolution()
	{
		$solution = [];
		for ($i = 0; $i < $this->size; $i++) {
			$solution[] = FALSE;
		}

		foreach (array_reverse($this->table[$i], TRUE) as $price => $weight) {
			if ($weight !== NULL && $weight <= $this->capacity) {
				$this->maxPrice = $price;
				break;
			}
		}

		$floater = $this->maxPrice;
		for ($i = $this->size; $i > 0; $i--) {
			if ($floater === 0) break;
			if ($this->table[$i][$floater] !== $this->table[$i - 1][$floater]) {
				$solution[$i - 1] = TRUE;
				$floater -= $this->prices[$i - 1];
			}
		}

		$this->solution = $solution;
	}


	private function getPrice($i)
	{
		if ($i === 0) return 0;
		return $this->prices[$i - 1];
	}


	private function getWeight($i)
	{
		if ($i === 0) return 0;
		return $this->weights[$i - 1];
	}


	private function printTable()
	{
		for ($y = $this->maxPotentialPrice; $y >= 0; $y--) {
			echo "|" . str_pad($y, 2) . "|";
			for ($i = 0; $i <= $this->size; $i++) {
				if ($this->table[$i][$y] === self::INFINITY) {
					echo "  i |";
				} else {
					echo " " . str_pad($this->table[$i][$y], 2) . " |";
				}
			}
			echo "\n";
		}

	}
}
