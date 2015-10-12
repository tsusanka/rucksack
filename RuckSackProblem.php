<?php


/**
 * Class RuckSackProblem
 */
class RuckSackProblem
{

	/** @var int[][] */
	private $items;


	public function __construct($id, $size, $weight, $parameters)
	{
		$this->parseParameters($parameters);
	}


	private function parseParameters($parameters)
	{
		$cnt = 0;
		for ($i = 0; $i < count($parameters); $i++) {
			if (!($i % 2)) {
				$this->items[$cnt]['w'] = $parameters[$i];

			} else {
				$this->items[$cnt]['p'] = $parameters[$i];
				$cnt++;
			}
		}
	}

}
