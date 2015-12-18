<?php
require_once('loader.php');


class RuckSackProblemAnnealing extends BaseRuckSackProblem
{

	const ANNEALING_RATE = 0.94;
	const EQUILIBRIUM = 5;
	const TEMP_START = 0.5;
	const TEMP_END = 0.1;

	/** @var int */
	private $temp = 0;

	/** @var int */
	private $tryStep = 0;

	/** @var int[] */
	private $workingOnSolution;


	public function solve()
	{
		$this->init();
		$this->temp = self::TEMP_START;

		$frozenFlag = TRUE;
		while (TRUE) {
			if ($frozenFlag && $this->frozen()) {
				break;
			}
			if (!$this->equilibrium()) {
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

	/**
	 * Randomly selects an item. If it is not in rucksack it adds it and checks.
	 * If it is, it removes it, if a specific conditions are met.
	 */
	private function tryState()
	{
		$key = array_rand($this->weights);

		$this->workingOnSolution[$key] = !$this->workingOnSolution[$key]; // neighbour
		list($better, $price) = $this->check();
		if ($better) {
			$this->maxPrice = $price;
			$this->solution = $this->workingOnSolution;
			return;
		}

		// delta magic
		$delta = ($price - $this->maxPrice);
		$x = mt_rand() / mt_getrandmax();
		if (!($x < exp($delta / $this->temp))) {
			$this->workingOnSolution[$key] = !$this->workingOnSolution[$key];
			// return new
		}
		// else return state
	}

	private function equilibrium()
	{
		return ++$this->tryStep === ($this->size * self::EQUILIBRIUM);
	}

	private function frozen()
	{
		return $this->temp <= self::TEMP_END;
	}

	private function cool()
	{
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
			return [FALSE, $price];
		}
		if ($price >= $this->maxPrice) {
			return [TRUE, $price];
		}
		return [FALSE, $price];
	}

	private function init()
	{
		$this->workingOnSolution = [];
		for ($i = 0; $i < $this->size; $i++) {
			$this->workingOnSolution[] = FALSE;
		}
	}

}
