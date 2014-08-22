<?php
namespace PrecisionMaths\Utility;

use DateTime;
use PrecisionMaths\Number;

class Finance
{
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
        $decimalTimeUtility = new DecimalTime();
    	$decimalHoursWorked = $decimalTimeUtility->dateRangeAsHours($start, $end);
    	
    	// Doesn't check the type of $breaksInMins here as just going to let Number class validation deal with it
    	if ($breakInMins !== null) {
    	    $precisionBreakInMins = Number::create($breakInMins);
    	    $precisionDecimalTimeBreak = $precisionBreakInMins->div(DecimalTime::MINUTES_IN_HOUR)
    	    $decimalHoursWorked = $decimalHoursWorked->sub($precisionDecimalTimeBreak);
    	};

    	return $hourlyRate->mul($decimalHoursWorked);
    }
}