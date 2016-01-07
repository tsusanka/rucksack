<?php

namespace Sat;

require_once('loader.php');


class SatSolverAnnealing extends SatSolver
{

	/** @var int */
	private $annealingRate;

	/** @var int */
	private $equilibrium;

	/** @var int */
	private $tempEnd;

	/** @var int */
	private $temp = 0;

	/** @var int */
	private $tryStep = 0;

	/** @var int[] */
	private $workingOnSolution;


	/**
	 * SatSolverAnnealing constructor.
	 * @param $varCount
	 * @param $clauseCount
	 * @param $weights
	 * @param $clauses
	 * @param $extra
	 */
	public function __construct($varCount, $clauseCount, $weights, $clauses, $extra)
	{
		parent::__construct($varCount, $clauseCount, $weights, $clauses);

		$this->setStartTemp($extra[0], $extra[3]);

		$this->annealingRate = $extra[1];
		$this->equilibrium = (int)$extra[2];
		$this->tempEnd = $extra[4];
	}


	/**
	 * Main annealing skeleton.
	 * @return array
	 */
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

		return [$this->maxPrice, $this->steps];
	}

	/**
	 * Randomly selects state and checks.
	 */
	private function tryState()
	{
		$key = array_rand($this->weights);

		$this->workingOnSolution[$key] = !$this->workingOnSolution[$key];
		list($better, $price) = $this->check();
		if ($better) {
			$this->maxPrice = $price;
			$this->solution = $this->workingOnSolution;
			return;
		}

		$delta = ($price - $this->maxPrice);
		$x = mt_rand() / mt_getrandmax();
		if (!($x < exp($delta / $this->temp))) {
			$this->workingOnSolution[$key] = !$this->workingOnSolution[$key];
			// return new
		}
		// else return state
	}

	/**
	 * Checks if current working solution is better.
	 * @return array
	 */
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

	/**
	 * @return bool
	 */
	private function equilibrium()
	{
		return ++$this->tryStep === ($this->varCount * $this->equilibrium);
	}

	/**
	 * @return bool
	 */
	private function frozen()
	{
		return $this->temp <= $this->tempEnd;
	}

	/**
	 * @return void
	 */
	private function cool()
	{
		$this->tryStep = 0;
		$this->temp *= $this->annealingRate;
	}

	/**
	 * @return void
	 */
	private function init()
	{
		$this->workingOnSolution = [];
		for ($i = 0; $i < $this->varCount; $i++) {
			$this->workingOnSolution[] = FALSE;
		}
	}

	/**
	 * Sets start temp according to mode.
	 * See the report for more details.
	 * @param $mode
	 * @param $parameter
	 * @throws \Exception
	 */
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
