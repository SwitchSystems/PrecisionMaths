<?php
namespace PrecisionMaths\Utility;

use DateTime;
use InvalidArgumentException;
use PrecisionMaths\Number;

/**
 * Utility for precise Decimal Time Calculations
 * @TODO: Implement Month and Year - currently these will just be ignored!
 * as we don't need this functionality as of yet
 */
class DecimalTime
{
    /**
     * @var string
     */
    const MINUTES_IN_HOUR = '60';
    
    /**
     * @var string
     */
    const SECONDS_IN_MINUTE = '60';
    
    /**
     * @var string
     */
    const HOURS_IN_DAY = '24';
    
    /**
     * @var string
     */
    const MINUTES_IN_DAY = '1440';
    
	public function dateRangeAsDays(DateTime $start, DateTime $end)
	{
		
	}

	/**
	 * 
	 * @param DateTime $start
	 * @param DateTime $end
	 * @return PrecisionMaths\Number
	 */
	public function dateRangeAsHours(DateTime $start, DateTime $end)
	{
	    $dateInterval = $this->calculateDateDiff($start, $end);
	    
	    // Calculate the hours in a day and assign to $hours
	    $hours = (new Number($dateInterval->d))->mul(static::HOURS_IN_DAY);

	    // Add the hours
	    $hours = $hours->add($dateInterval->h);
	     
	    // Calculate the minutes value in hours and add to $hours
	    $hoursFromMinutes = (new Number($dateInterval->i))->div(static::MINUTES_IN_HOUR);
	    $hours = $hours->add($hoursFromMinutes);
	     
	    // Calculate the seconds value in hours and add to $hours
	    $secondsInMinutes = (new Number($dateInterval->i))->div(static::SECONDS_IN_MINUTE);
	    $hoursFromSeconds = $secondsInMinutes->div(static::MINUTES_IN_HOUR);
	    $hours = $hours->add($hoursFromSeconds);
	    
	    return $hours;
	}
	
	public function dateRangeAsMinutes(DateTime $start, DateTime $end)
	{
	    $dateInterval = $this->calculateDateDiff($start, $end);
	    
	    // Calculate the minutes from days and assign to $minutes
	    $minutes = (new Number($dateInterval->d))->mul(static::MINUTES_IN_DAY);

	    // Calculate minutes from hours and add to $minutes
	    $minutesFromHours = (new Number($dateInterval->h))->mul(static::MINUTES_IN_HOUR);
	    $minutes->add($minutesFromHours);
	}
	
	public function dateRangeAsSeconds(DateTime $start, DateTime $end)
	{
	
	}

	protected function calculateDateDiff(DateTime $start, DateTime $end)
	{
	    $dateInterval = $start->diff($end);

	    return $dateInterval; 
	}
}