<?php


/**
 * Class RuckSackProblem
 */
class RuckSackProblem
{

	/** @var int number of available items */
	private $size;

	/** @var int */
	private $capacity;

	/** @var int[] */
	private $weights;

	/** @var int[] */
	private $prices;

	/** @var boolean[] */
	private $solution;

	/** @var int */
	private $maxPrice = 0;


	public function __construct($id, $size, $capacity, $parameters)
	{
		$this->size = $size;
		$this->capacity = $capacity;
		$this->parseParameters($parameters);
	}


	public function solve()
	{
		$init = [FALSE, FALSE, FALSE, FALSE];
		$this->check($init);
		$this->walk(0, $init);
		de($this->solution);
	}


	public function walk($index, $values)
	{
		if ($index === $this->size) {
			return $values;
		}

		$this->walk($index + 1, $values);
		$values[$index] = !$values[$index];

		$this->check($values);

		return $this->walk($index + 1, $values);
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
		if ($price > $this->maxPrice) {
			$this->maxPrice = $price;
			$this->solution = $booleans;
		}
	}


	private function parseParameters($parameters)
	{
		$cnt = 0;
		for ($i = 0; $i < count($parameters); $i++) {
			if (!($i % 2)) {
				$this->weights[$cnt] = $parameters[$i];

			} else {
				$this->prices[$cnt] = $parameters[$i];
				$cnt++;
			}
		}
	}

}
