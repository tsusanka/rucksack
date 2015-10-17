<?php
require_once('loader.php');


/**
 * Class RuckSackProblem
 */
class RuckSackProblemBrute extends BaseRuckSackProblem
{

	public function solve()
	{
		$init = [];
		for ($i = 0; $i < $this->size; $i++) {
			$init[] = FALSE;
		}
		$this->check($init);
		$this->walk(0, $init);
		$this->printSolution();
	}


	public function walk($index, $values)
	{
		if ($index === $this->size) {
			return $values;
		}

		$this->walk($index + 1, $values);
		$values[$index] = !$values[$index];

		$this->check($values);

		$this->walk($index + 1, $values);
	}


	private function check($booleans)
	{
		$weight = $price = 0;
		for ($i = 0; $i < $this->size; $i++) {
			if (!$booleans[$i]) {
				continue;
			}
			$weight += $this->weights[$i];
			$price += $this->prices[$i];
		}

		if ($weight > $this->capacity) {
			return;
		}
		if ($price >= $this->maxPrice) {
			$this->maxPrice = $price;
			$this->solution = $booleans;
		}
	}

}
