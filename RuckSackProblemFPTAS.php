<?php
require_once('loader.php');


class RuckSackProblemFPTAS extends RuckSackProblemDynamic
{

	/** @const int */
	const ERROR_RATE = 0.2;

	/** @const int */
	private $shiftSize;

	/** @const int[] */
	private $realPrices;


	public function solve()
	{
		$this->shiftSize = floor(log((self::ERROR_RATE * max($this->prices) / $this->size)));
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
