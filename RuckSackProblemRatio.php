<?php
require_once('loader.php');


class RuckSackProblemRatio extends BaseRuckSackProblem
{

	private $ratios;


	public function solve()
	{
		foreach ($this->weights as $i => $weight) {
			$this->ratios[] = $this->prices[$i] / $weight;
		}
		asort($this->ratios);
		$this->ratios = array_reverse($this->ratios, TRUE);
		$this->add();
		return $this->maxPrice;
	}


	private function add()
	{
		$weight = $price = 0;
		foreach ($this->ratios as $i => $ratio) {
			if ($this->weights[$i] + $weight > $this->capacity) {
				$this->solution[$i] = FALSE;
				continue;
			}
			$weight += $this->weights[$i];
			$price += $this->prices[$i];
			$this->solution[$i] = TRUE;
		}
		$this->maxPrice = $price;
	}

}
