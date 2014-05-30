<?php

/**
 * Author: imsamurai <im.samuray@gmail.com>
 * Date: 05.09.2012
 * Time: 13:54:17
 */

/**
 * Class for date range
 *
 * @package DateRange
 * @subpackage Utility
 */
class DateRange {

	/**
	 * Start date
	 *
	 * @var DateTime
	 */
	protected $_startDate = null;

	/**
	 * End date
	 *
	 * @var DateTime
	 */
	protected $_endDate = null;

	/**
	 * Constructor
	 *
	 * @param DateTime|string|int $start Start date
	 * @param DateTime|string|int $end End date
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct($start, $end = null) {
		if ($start instanceof DateTime) {
			$this->_startDate = clone $start;
		} elseif (!is_numeric($start)) {
			$this->_startDate = new DateTime($start);
		} else {
			$this->_startDate = new DateTime();
			$this->_startDate->setTimestamp($start);
		}

		if (is_null($end)) {
			$this->_endDate = clone $this->_startDate;
			$this->_endDate->setTime(23, 59, 59);
		} elseif ($end instanceof DateTime) {
			$this->_endDate = clone $end;
		} elseif (!is_numeric($end)) {
			$this->_endDate = new DateTime($end);
		} else {
			$this->_endDate = new DateTime();
			$this->_endDate->setTimestamp($end);
		}
		if ($this->_startDate > $this->_endDate) {
			throw new InvalidArgumentException('Start date must be less or equal to end date');
		}
	}

	/**
	 * Returns start date object
	 *
	 * @return DateTime
	 */
	public function start() {
		return clone $this->_startDate;
	}

	/**
	 * Returns end date object
	 *
	 * @return DateTime
	 */
	public function end() {
		return clone $this->_endDate;
	}

	/**
	 * Return formatted start date
	 *
	 * @param string $format Date format
	 * @return string
	 */
	public function startFormat($format) {
		return $this->_startDate->format($format);
	}

	/**
	 * Return formatted end date
	 *
	 * @param string $format Date format
	 * @return string
	 */
	public function endFormat($format) {
		return $this->_endDate->format($format);
	}

	/**
	 * CreateIterator for given interval $time
	 *
	 * @param string $time
	 * @return ArrayIterator
	 */
	public function period($time) {
		$Dates = array();
		$NextDate = $this->start();
		while ($NextDate <= $this->_endDate) {
			$Dates[] = clone $NextDate;
			$NextDate->modify("+$time");
		}
		return new ArrayIterator($Dates);
	}

	/**
	 * Returns true if $Date belongs to this range
	 * 
	 * @param DateTime $Date Checked date
	 * @param bool $inclusive True means include range edges
	 */
	public function isContains(DateTime $Date, $inclusive = true) {
		if ($inclusive) {
			return $this->_startDate <= $Date && $Date <= $this->_endDate;
		} else {
			return $this->_startDate < $Date && $Date < $this->_endDate;
		}
	}

}
