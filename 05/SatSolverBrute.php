<?php

namespace Sat;

require_once('loader.php');


class SatSolverBrute extends SatSolver
{

	public function solve()
	{
		$values = [];
		for ($i = 0; $i < $this->varCount; $i++) {
			$values[] = 0;
		}
		$this->check($values);
		$this->walk(0, $values);
		return $this->maxPrice;
	}

	protected function check($values)
	{
		if ($this->evaluate($values)) {
			$price = $this->enumerate($values);
			if ($price > $this->maxPrice) {
				$this->maxPrice = $price;
				$this->solution = $values;
			}
		}
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

}
