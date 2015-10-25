<?php
require_once('loader.php');


class RuckSackProblemBB extends BaseRuckSackProblem
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



		if ($this->isPerspective($values, $index)) {
			$this->walk($index + 1, $values);
			$values[$index] = !$values[$index];
			$this->walk($index + 1, $values);
		}

		$this->check($values);
	}


	/**
	 * Returns true if this recursion branch is perspective,
	 * aka if it may return larger maximum price.
	 * @param [] $values
	 * @param int $index
	 * @return boolean
	 */
	private function isPerspective($values, $index)
	{
		$nextTrue = $values;
		$nextTrue[$index] = TRUE;
		$weight = $price = 0;
		for ($i = 0; $i < $this->size; $i++) {
			if ($i <= $index && !$nextTrue[$i]) {
				continue;
			}
			$price += $this->prices[$i];
			$weight += $this->weights[$i];
		}
		if ($price <= $this->maxPrice) {
			return FALSE;
		}
		return TRUE;
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
