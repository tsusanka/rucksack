<?php
require_once('loader.php');


class RuckSackProblemAnnealing extends BaseRuckSackProblem
{

	private $annealingRate = 0.94;
	private $equilibrium = 5;
	private $tempStart = 3;
	private $tempEnd = 0.1;

	/** @var int */
	private $temp = 0;

	/** @var int */
	private $tryStep = 0;

	/** @var int[] */
	private $workingOnSolution;


	public function __construct($args, $extra)
	{
		parent::__construct($args);
		$this->annealingRate = $extra[0];
		$this->equilibrium = $extra[1];
		$this->tempStart = $extra[2];
		$this->tempEnd = $extra[3];

	}

	public function solve()
	{
		$this->init();
		$this->temp = $this->tempStart;

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
		return ++$this->tryStep === ($this->size * $this->equilibrium);
	}

	private function frozen()
	{
		return $this->temp <= $this->tempEnd;
	}

	private function cool()
	{
		$this->tryStep = 0;
		$this->temp *= $this->annealingRate;
	}

	private function check()
	{
		$this->step();
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
