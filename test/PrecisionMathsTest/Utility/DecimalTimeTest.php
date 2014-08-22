<?php
namespace PrecisionMathsTest\Utility;

use PrecisionMaths\Utility\DecimalTime;
use DateTime;

class DecimalTimeTest extends \PHPUnit_Framework_TestCase
{
	public function testDateRangeHours()
	{
		$util = new DecimalTime();

		$start = new DateTime('2014-05-02 9:00');
		$end = new DateTime('2014-05-03 9:00');

		$util->dateRangeAsHours($start, $end);
	}
}