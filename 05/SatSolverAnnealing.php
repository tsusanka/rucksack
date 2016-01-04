<?php

namespace Sat;

require_once('loader.php');


class SatSolverAnnealing extends SatSolver
{

	private $annealingRate;
	private $equilibrium;
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

		$this->setStartTemp($extra[0], $extra[3]);

		$this->annealingRate = $extra[1];
		$this->equilibrium = (int) $extra[2];
		$this->tempEnd = $extra[4];
	}


	public function solve()
	{
		$this->init();

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

	private function setStartTemp($mode, $parameter)
	{
		$max = max($this->weights);
		switch ($mode) {
			case 1:
				$this->temp = $parameter;
				break;
			case 2:
				$this->temp = $parameter * $max;
				break;
			case 3:
				$this->temp = $parameter * ($max / $this->varCount);
				break;
			case 4:
				$this->temp = $parameter * ($max / $this->clauseCount);
				break;
			default:
				throw new \Exception('Set start temp mode unknown.');
		}
	}

}
