<?php


/**
 * Class RuckSackProblem
 */
class RuckSackProblem
{

	/** @var int */
	private $id;

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


	public function __construct($args)
	{
		$this->parseParameters($args);
	}


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
		if ($price >= $this->maxPrice) {
			$this->maxPrice = $price;
			$this->solution = $booleans;
		}
	}


	private function printSolution()
	{
		$string = $this->id . ' ' . $this->size . ' ' . $this->maxPrice . '  ';
		foreach ($this->solution as $boolean) {
			$string .= (int) $boolean . ' ';
		}
		echo substr($string, 0, -1) . "\n";
	}


	private function parseParameters($args)
	{
		$this->id = (int) $args[0];
		$this->size = (int) $args[1];
		$this->capacity = (int) $args[2];
		$parameters = array_slice($args, 3);

		$cnt = 0;
		for ($i = 0; $i < count($parameters); $i++) {
			if (!($i % 2)) {
				$this->weights[$cnt] = (int) $parameters[$i];

			} else {
				$this->prices[$cnt] = (int) $parameters[$i];
				$cnt++;
			}
		}
	}

}
