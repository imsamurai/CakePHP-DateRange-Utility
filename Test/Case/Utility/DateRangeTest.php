<?php

/**
 * Author: imsamurai <im.samuray@gmail.com>
 * Date: Mar 13, 2014
 * Time: 12:34:22 PM
 * Format: http://book.cakephp.org/2.0/en/development/testing.html
 */
App::uses('DateRange', 'DateRange.Utility');

/**
 * DateRangeTest
 */
class DateRangeTest extends CakeTestCase {

	/**
	 * Test period generation
	 * 
	 * @param string $start
	 * @param string $end
	 * @param string $time
	 * @param array $dates
	 * 
	 * @dataProvider periodProvider
	 */
	public function testPeriod($start, $end, $time, array $dates) {
		$DateRange = new DateRange($start, $end);
		$Period = $DateRange->period($time);
		$count = 0;
		foreach ($Period as $index => $Date) {
			$count++;
			/* @var $Date DateTime */
			$this->assertEqual($Date->format('d.m.Y H:i:s'), $dates[$index]);
			debug($Date->format('d.m.Y H:i:s'));
		}
		$this->assertEqual($count, count($dates));
	}
	
	/**
	 * Data provider for testPeriod
	 * 
	 * @return array
	 */
	public function periodProvider() {
		return array(
			//$start, $end, $time, array $dates
			//set #0
			array(
				'12.03.2004',
				'12.03.2004',
				'1 day',
				array('12.03.2004 00:00:00')
			),
			//set #1
			array(
				'12.03.2004',
				'13.03.2004',
				'1 day',
				array('12.03.2004 00:00:00', '13.03.2004 00:00:00')
			),
			//set #3
			array(
				'12.03.2004',
				'12.03.2004 23:59:59',
				'12 hours',
				array('12.03.2004 00:00:00', '12.03.2004 12:00:00')
			),
			//set #4
			array(
				'12.03.2004',
				'12.03.2004 23:59:59',
				'12 hours',
				array('12.03.2004 00:00:00', '12.03.2004 12:00:00')
			),
			//set #5
			array(
				'12.03.2004',
				null,
				'12 hours',
				array('12.03.2004 00:00:00', '12.03.2004 12:00:00')
			),
			//set #6
			array(
				'12.03.2004',
				'13.03.2004 00:00:01',
				'12 hours',
				array('12.03.2004 00:00:00', '12.03.2004 12:00:00', '13.03.2004 00:00:00')
			),
			//set #7
			array(
				'12.03.2004 23:59:58',
				'13.03.2004 00:00:02',
				'1 second',
				array('12.03.2004 23:59:58', '12.03.2004 23:59:59', '13.03.2004 00:00:00', '13.03.2004 00:00:01', '13.03.2004 00:00:02')
			),
		);
	}
	
	/**
	 * Test date range construct
	 * 
	 * @param string|int|DateTime $start
	 * @param string|int|DateTime $end
	 * @param DateTime $ExpectedStart
	 * @param DateTime $ExpectedEnd
	 * 
	 * @dataProvider constructProvider
	 */
	public function testConstruct($start, $end, $ExpectedStart, $ExpectedEnd) {
		$DateRange = new DateRange($start, $end);
		$this->assertEquals($ExpectedStart, $DateRange->start());
		$this->assertEquals($ExpectedEnd, $DateRange->end());
	}
	
	/**
	 * Data provider for testConstruct
	 * 
	 * @return array
	 */
	public function constructProvider() {
		return array(
			//$start, $end, $ExpectedStart, $ExpectedEnd
			//set #0
			array(
				'12.03.2004 23:59:58',
				null,
				new DateTime('12.03.2004 23:59:58'),
				new DateTime('12.03.2004 23:59:59')
			),
			//set #1
			array(
				'12.03.2004 23:59:50',
				'12.03.2004 23:59:58',
				new DateTime('12.03.2004 23:59:50'),
				new DateTime('12.03.2004 23:59:58')
			),
			//set #2
			array(
				new DateTime('12.03.2004 23:59:50'),
				new DateTime('12.03.2004 23:59:58'),
				new DateTime('12.03.2004 23:59:50'),
				new DateTime('12.03.2004 23:59:58')
			),
			//set #3
			array(
				(new DateTime('12.03.2004 23:59:50'))->getTimestamp(),
				(new DateTime('12.03.2004 23:59:58'))->getTimestamp(),
				new DateTime('12.03.2004 23:59:50'),
				new DateTime('12.03.2004 23:59:58')
			),
			//set #4
			array(
				(new DateTime('12.03.2004 23:59:50'))->getTimestamp(),
				null,
				new DateTime('12.03.2004 23:59:50'),
				new DateTime('12.03.2004 23:59:59')
			),
		);
	}
	
	/**
	 * Test exception when end date greater than start date
	 */
	public function testInvalidRange() {
		$this->expectException('InvalidArgumentException');
		new DateRange('12.03.2005', '12.03.2004');
	}
	
	/**
	 * Test data formatting
	 */
	public function testFormat() {
		$Start = new DateTime('12.03.2004');
		$End = new DateTime('12.03.2005');
		$DateRange = new DateRange($Start, $End);
		$format = 'm.d.Y H:i:s';
		$this->assertSame($Start->format($format), $DateRange->startFormat($format));
		$this->assertSame($End->format($format), $DateRange->endFormat($format));
	}

}
