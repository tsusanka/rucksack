<?php
require_once('loader.php');


class RuckSackProblemAnnealing extends BaseRuckSackProblem
{

	const ANNEALING_RATE = 0.95;
	const EQUILIBRIUM = 50;
	const TEMP_START = 0.0044;
	const TEMP_END = 0.00001;

	/** @var int */
	private $temp = 0;

	/** @var int */
	private $tryStep = 0;

	/** @var int[] */
	private $workingOnSolution;


	public function solve()
	{
		$this->init();
		$this->setStartTemp();

		$frozenFlag = TRUE;
		while (TRUE) {
			if ($frozenFlag && $this->frozen()) {
				break;
			}
			if (!$this->equilibrium()) {
//				echo "#$this->tryStep attempt on temp $this->temp\n";
				$this->tryState();
				$frozenFlag = FALSE;
			} else {
				$this->cool();
				$frozenFlag = TRUE;
			}
		}

		$this->printSolution();
		return $this->maxPrice;
	}


	private function setStartTemp()
	{
		$this->temp = self::TEMP_START;
		return;
		$prices = $weights = 0;
		for ($i = 0; $i < $this->size; $i++) {
			$prices = $this->prices[$i];
			$weights = $this->weights[$i];
		}
		$this->temp = ($prices / $this->size) / ($weights / $this->capacity) * self::TEMP_START;
	}

	/**
	 * Randomly selects an item. If it is not in rucksack it adds it and checks.
	 * If it is, it removes it, if a specific conditions are met.
	 */
	private function tryState()
	{
		$key = array_rand($this->weights);

		if (!$this->workingOnSolution[$key]) { // not in the bag
			$this->workingOnSolution[$key] = TRUE;
			if ($price = $this->check()) {
				// return new
				echo $price . "\n";
				$this->maxPrice = $price;
				$this->solution = $this->workingOnSolution;
				return;
			}
		}
		// delta magic
		$delta = -($this->prices[$key] - $this->maxPrice);
		$x = mt_rand() / mt_getrandmax();
		if ($x < exp($delta / $this->temp)) {
			$this->workingOnSolution[$key] = FALSE;
			// return new
		}
		// else return state
	}

	private function equilibrium()
	{
		return ++$this->tryStep === $this->size * self::EQUILIBRIUM;
	}

	private function frozen()
	{
		return $this->temp <= self::TEMP_END;
	}

	private function cool()
	{
		echo "cooling $this->temp\n";
		$this->tryStep = 0;
		$this->temp *= self::ANNEALING_RATE;
	}


	private function check()
	{
		$weight = $price = 0;
		for ($i = 0; $i < $this->size; $i++) {
			if (!$this->workingOnSolution[$i]) {
				continue;
			}
			$weight += $this->weights[$i];
			$price += $this->prices[$i];
		}

		if ($weight > $this->capacity) {
			return FALSE;
		}
		if ($price >= $this->maxPrice) {
			return $price;
		}
		return FALSE;
	}


	private function init()
	{
		$this->workingOnSolution = [];
		for ($i = 0; $i < $this->size; $i++) {
			$this->workingOnSolution[] = FALSE;
		}
	}


	private function p($booleans)
	{
		$string = $this->id . ' ' . $this->size . ' ' . $this->maxPrice . '  ';
		foreach ($booleans as $boolean) {
			$string .= (int) $boolean . ' ';
		}
		echo substr($string, 0, -1);
	}

}
