<?php

namespace Sat;

require_once('loader.php');


class SatSolverAnnealing extends SatSolver
{

	private $annealingRate;
	private $equilibrium;
	private $tempStart;
	private $tempEnd;

	/** @var int */
	private $temp = 0;

	/** @var int */
	private $tryStep = 0;

	/** @var int[] */
	private $workingOnSolution;


	public function __construct($varCount, $clauseCount, $weights, $clauses, $extra)
	{
		parent::__construct($varCount, $clauseCount, $weights, $clauses);
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

//		$this->printSolution();
		return [$this->maxPrice, $this->steps];
	}

	/**
	 * Randomly selects an item.
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


	protected function check()
	{
		$this->step();
		$price = $this->enumerate($this->workingOnSolution);
		if ($this->evaluate($this->workingOnSolution)) {
			if ($price > $this->maxPrice) {
				return [TRUE, $price];
			}
		}
		return [FALSE, $price];
	}


	private function equilibrium()
	{
		return ++$this->tryStep === ($this->varCount * $this->equilibrium);
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

	private function init()
	{
		$this->workingOnSolution = [];
		for ($i = 0; $i < $this->varCount; $i++) {
			$this->workingOnSolution[] = FALSE;
		}
	}

}
