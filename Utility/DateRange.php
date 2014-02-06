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
	public function __construct($start, $end) {
		if ($start instanceof DateTime) {
			$this->_startDate = clone $start;
		} elseif (!is_numeric($start)) {
			$this->_startDate = new DateTime($start);
		} else {
			$this->_startDate = new DateTime();
			$this->_startDate->setTimestamp($start);
		}

		if ($end instanceof DateTime) {
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
	 * Create DatePeriod object for given interval $time
	 * See http://ua2.php.net/manual/en/class.dateperiod.php
	 *
	 * @param string $time See http://ua2.php.net/manual/en/dateinterval.createfromdatestring.php
	 * @return DatePeriod
	 */
	public function period($time) {
		return new DatePeriod(
				$this->_startDate, DateInterval::createFromDateString($time), $this->_endDate
		);
	}

}
