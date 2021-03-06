<?php
/* Copyright (c) 2014, 2015 Switch Systems Ltd
 *
* This Source Code Form is subject to the terms of the Mozilla Public
* License, v. 2.0. If a copy of the MPL was not distributed with this
* file, You can obtain one at http://mozilla.org/MPL/2.0/. */

namespace PrecisionMathsTest;

use PrecisionMaths\Utility\FinanceUtility;
use DateTime;

class FinanceUtilityTest extends \PHPUnit_Framework_TestCase
{
	public function testCalculatePayForPeriod()
	{
		$util = new FinanceUtility();
		$preciseUtil = new FinanceUtility();
		
		$start = new DateTime('2014-05-03 9:00');
		$end = new DateTime('2014-05-03 17:00');
        $hourlyRate = '6.00';		
		$result = $util->calculatePayForPeriod($start, $end, $hourlyRate);
		$this->assertEquals('48.00', $result);
		
		$start = new DateTime('2014-05-03 9:00');
		$end = new DateTime('2014-05-03 17:59:01');
		$hourlyRate = '6.00';
		$result = $preciseUtil->calculatePayForPeriod($start, $end, $hourlyRate);
		$this->assertEquals('53.90166666666666666660', $result);
		
		$start = new DateTime('2014-05-03 9:00');
		$end = new DateTime('2014-05-03 17:00:00');
		$hourlyRate = '6.50';
		$result = $util->calculatePayForPeriod($start, $end, $hourlyRate);
		$this->assertEquals('52.00', $result);
		
		$start = new DateTime('2014-05-03 9:00');
		$end = new DateTime('2014-05-03 17:00:00');
		$hourlyRate = '6.50';
		$result = $util->calculatePayForPeriod($start, $end, $hourlyRate, 30);
		$this->assertEquals('48.75', $result);
	}
}