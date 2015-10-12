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
		$cnt = 0;
		foreach ($parameters as $val) {
			$this->items[$cnt]['weight'] = $val;
			$this->items[$cnt++]['price'] = $val;
		}
		var_dump($this->items);
		exit;
	}

}
