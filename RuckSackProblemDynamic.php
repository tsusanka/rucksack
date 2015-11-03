<?php
require_once('loader.php');


class RuckSackProblemDynamic extends BaseRuckSackProblem
{

	const INFINITY = 99999999999;

	protected $maxPotentialPrice;

	protected $table;


	public function solve()
	{
		$this->maxPotentialPrice = array_sum($this->prices);
		$this->init();

		for ($i = $this->maxPotentialPrice; $i > 0; $i--) {
			$this->W($this->size, $i);
		}
		$this->printSolution();
	}


	private function init()
	{
		for ($i = 0; $i <= $this->size; $i++) {
			for ($y = 0; $y <= $this->maxPotentialPrice; $y++) {
				$this->table[$i][$y] = NULL;
			}
		}
	}


	protected function printSolution()
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

		$tr = $this->maxPrice; // traversing index - name? @todo
		for ($i = $this->size; $i > 0; $i--) {
			if ($this->table[$i][$tr] !== $this->table[$i - 1][$tr]) {
				$solution[$i - 1] = TRUE;
				$tr -= $this->prices[$i - 1];
			}
		}

		$this->solution = $solution;
		parent::printSolution();
	}


	private function W($i, $c)
	{
		if ($c < 0) return self::INFINITY;
		if ($i === 0 && $c === 0) return 0;
		if ($i === 0) return self::INFINITY;
		if ($this->table[$i][$c] !== NULL) {
			return $this->table[$i][$c];
		}

		$this->table[$i][$c] = $res = min($this->W($i - 1, $c), $this->W($i - 1, $c - $this->getPrice($i)) + $this->getWeight($i));

		return $res;
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
