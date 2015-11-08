<?php
require_once('loader.php');


class RuckSackProblemFPTAS extends RuckSackProblemDynamic
{

	/** @const int */
	private $errorRate = 0.2;

	/** @const int */
	private $shiftSize;

	/** @const int[] */
	private $realPrices;


	public function __construct($arguments, $eps = NULL)
	{
		parent::__construct($arguments);
		if ($eps) {
			$this->errorRate = (float) $eps;
		}
	}


	public function solve()
	{
		$this->shiftSize = floor(log(($this->errorRate * max($this->prices) / $this->size)));
		if ($this->shiftSize < 0) $this->shiftSize = 0;

		$this->realPrices = $this->prices;
		foreach ($this->prices as $key => $price) {
			$this->prices[$key] = $price >> $this->shiftSize;
		}

		parent::solve();

		$this->prices = $this->realPrices;
		$this->recalculatePrice();
	}


	public function recalculatePrice()
	{
		$this->maxPrice = 0;
		for ($i = 0; $i < $this->size; $i++) {
			if (!$this->solution[$i]) {
				continue;
			}
			$this->maxPrice += $this->prices[$i];
		}
	}

}
