<?php
/* Copyright (c) 2014, 2015 Switch Systems Ltd
 *
* This Source Code Form is subject to the terms of the Mozilla Public
* License, v. 2.0. If a copy of the MPL was not distributed with this
* file, You can obtain one at http://mozilla.org/MPL/2.0/. */

namespace PrecisionMaths\Utility;

use DateTime;
use PrecisionMaths\Number;

/**
 * Utility class for all financial calculations 
 */
class FinanceUtility
{
    /**
     * @var string
     */
    protected $scale;
    
    /**
     * @param string $scale
     */
    public function __construct($scale = Number::DEFAULT_SCALE)
    {
        // Don't worry about a default scale, let Number class take care of it
        $this->scale = $scale;
    }
    
    /**
     * Calulates pay based and returns as instance of Precision\Number
     * 
     * @param DateTime $start
     * @param DateTime $end
     * @param float $hourlyRate
     * 
     * @return PrecisionMaths\Number
     */
    public function calculatePayForPeriod(DateTime $start, DateTime $end, $hourlyRate, $breakInMins = null)
    {
        $decimalTimeUtility = new DecimalTimeUtility($this->scale);
    	$decimalHoursWorked = $decimalTimeUtility->dateRangeAsHours($start, $end);
    	
    	// Doesn't check the type of $breaksInMins here as just going to let Number class validation deal with it
    	if ($breakInMins !== null) {
    	    $precisionBreakInMins = Number::create($breakInMins, $this->scale);
    	    $precisionDecimalTimeBreak = $precisionBreakInMins->div(DecimalTimeUtility::MINUTES_IN_HOUR);
    	    $decimalHoursWorked = $decimalHoursWorked->sub($precisionDecimalTimeBreak);
    	    
    	};
    	return $decimalHoursWorked->mul($hourlyRate);
    }
}