<?php
require_once('loader.php');


abstract class BaseRuckSackProblem
{

	/** @var int */
	protected $id;

	/** @var int number of available items */
	protected $size;

	/** @var int */
	protected $capacity;

	/** @var int[] */
	protected $weights;

	/** @var int[] */
	protected $prices;

	/** @var boolean[] */
	protected $solution;

	/** @var int */
	protected $maxPrice = 0;

	/** @var int */
	protected $steps = 0;


	public function __construct($args)
	{
		$this->parseParameters($args);
	}


	public function getSolution()
	{
		ksort($this->solution);
		$string = $this->id . ' ' . $this->size . ' ' . $this->maxPrice . '  ';
		foreach ($this->solution as $boolean) {
			$string .= (int) $boolean . ' ';
		}
		return substr($string, 0, -1);
	}


	public function printSolution()
	{
		echo $this->getSolution();
	}


	protected function parseParameters($args)
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


	protected function step()
	{
		$this->steps++;
	}


	public function printSteps()
	{
		echo "   S: $this->steps \n";
	}


	abstract public function solve();

}
