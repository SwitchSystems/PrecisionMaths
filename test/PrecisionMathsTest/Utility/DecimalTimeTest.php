<?php
namespace PrecisionMathsTest\Utility;

use PrecisionMaths\Utility\DecimalTime;
use DateTime;

class DecimalTimeTest extends \PHPUnit_Framework_TestCase
{
	public function testDateRangeHours()
	{
		$util = new DecimalTime(2);

		$start = new DateTime('2014-05-02 9:00');
		$end = new DateTime('2014-05-03 9:00');
		$this->assertEquals('24.00', $util->dateRangeAsHours($start, $end));
		
		$start = new DateTime('2014-05-03 9:00');
		$end = new DateTime('2014-05-03 17:00');
		$this->assertEquals('8.00', $util->dateRangeAsHours($start, $end));
		
		$start = new DateTime('2014-05-03 9:00');
		$end = new DateTime('2014-05-03 17:30');
		$this->assertEquals('8.50', $util->dateRangeAsHours($start, $end));
		
		$start = new DateTime('2014-05-02 9:00');
		$end = new DateTime('2014-05-03 17:30');
		$this->assertEquals('32.50', $util->dateRangeAsHours($start, $end));
		
		$utilMorePrecise = new DecimalTime(20);
		$start = new DateTime('2014-05-03 17:00');
		$end = new DateTime('2014-05-03 17:59');
		$this->assertEquals('0.98333333333333333333', $utilMorePrecise->dateRangeAsHours($start, $end));
		
		$utilMorePrecise = new DecimalTime(20);
		$start = new DateTime('2014-05-02 09:00');
		$end = new DateTime('2014-05-03 17:59');
		$this->assertEquals('32.98333333333333333333', $utilMorePrecise->dateRangeAsHours($start, $end));

		$utilMorePrecise = new DecimalTime(20);
		$start = new DateTime('2014-05-02 09:00:10');
		$end = new DateTime('2014-05-03 17:59:00');
		$this->assertEquals('32.98055555555555555554', $utilMorePrecise->dateRangeAsHours($start, $end));
	}
	
	public function testInvalidDateRangeHours()
	{
	    $this->setExpectedException('BadMethodCallException');
	    
	    $util = new DecimalTime(2);
	    
	    $start = new DateTime('2014-05-03 9:00');
	    $end = new DateTime('2014-05-03 05:00');
	    $this->assertEquals('8.00', $util->dateRangeAsHours($start, $end));
	}
	
	public function testDateRangeMinutes()
	{
	    $util = new DecimalTime(2);
	    $utilMorePrecise = new DecimalTime(20);
	    
	    $start = new DateTime('2014-05-02 9:00');
	    $end = new DateTime('2014-05-02 17:00');
	    $this->assertEquals('480.00', $util->dateRangeAsMinutes($start, $end));
	    
	    $start = new DateTime('2014-05-02 9:00');
	    $end = new DateTime('2014-05-02 17:20');
	    $this->assertEquals('500.00', $util->dateRangeAsMinutes($start, $end));
	    

	    $start = new DateTime('2014-05-02 9:00:00');
	    $end = new DateTime('2014-05-02 17:20:31');
	    $this->assertEquals('500.51666666666666666666', $utilMorePrecise->dateRangeAsMinutes($start, $end));
	}
	
	public function testInvalidDateRangeMinutes()
	{
	    $this->setExpectedException('BadMethodCallException');
	     
	    $util = new DecimalTime(2);
	     
	    $start = new DateTime('2014-05-03 9:00');
	    $end = new DateTime('2014-05-03 8:59:59');
	    $this->assertEquals('8.00', $util->dateRangeAsMinutes($start, $end));
	}
	
	public function testDateRangeSeconds()
	{
	    $util = new DecimalTime(2);
	    $utilMorePrecise = new DecimalTime(20);
	     
	    $start = new DateTime('2014-05-02 9:00');
	    $end = new DateTime('2014-05-02 17:00');
	    $this->assertEquals('28800.00', $util->dateRangeAsSeconds($start, $end));

	    $start = new DateTime('2014-05-02 9:00:00');
	    $end = new DateTime('2014-05-02 17:00:22');
	    $this->assertEquals('28822.00', $util->dateRangeAsSeconds($start, $end));
	    
	    $start = new DateTime('2014-05-01 9:00:00');
	    $end = new DateTime('2014-05-02 17:00:22');
	    $this->assertEquals('115222.00', $util->dateRangeAsSeconds($start, $end));
	}
}