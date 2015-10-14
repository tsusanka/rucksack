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

	/** @var int[][] */
	private $availableItems;

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
		$this->x(0, [TRUE, TRUE, TRUE, TRUE]);
		de($this->solution);
	}


	public function x($index, $values)
	{
		if ($index === $this->size) {
			return $values;
		}
		$this->check($values);

		$this->x($index + 1, $values);
		$values[$index] = !$values[$index];

		return $this->x($index + 1, $values);
	}


	private function check($booleans)
	{
		$weight = $price = 0;
		foreach ($this->availableItems as $key => $item) {
			if (!$booleans[$key]) {
				continue;
			}
			$weight += $item['w'];
			$price += $item['p'];
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
				$this->availableItems[$cnt]['w'] = $parameters[$i];

			} else {
				$this->availableItems[$cnt]['p'] = $parameters[$i];
				$cnt++;
			}
		}
	}

}
