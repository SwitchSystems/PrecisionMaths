<?php
namespace PrecisionMaths\Utility;

use DateTime;
use InvalidArgumentException;
use PrecisionMaths\Number;

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
    const DAYS = 'days';
    
    /**
     * @var string
     */
    const HOURS = 'hours';
    
    /**
     * @var string
     */
    const MINUTES = 'minutes';
    
    /**
     * @var string
     */
    const SECONDS = 'seconds';
    
    
	public function dateRangeAsDays(DateTime $start, DateTime $end)
	{
		
	}

	public function dateRangeAsHours(DateTime $start, DateTime $end)
	{
	    $dateInterval = $this->calculateDateDiff($start, $end);
	    
	    // Calculate the hours in a day and add to $hours
	    $hoursFromDays = (new Number($dateInterval->d))->mul(static::HOURS_IN_DAY);
	    $hours = $hoursFromDays;

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

	}
	
	public function dateRangeAsSeconds(DateTime $start, DateTime $end)
	{
	
	}
	
	protected function dateRangeAs(DateTime $start, DateTime $end, $unit)
	{
	    $dateInterval = $this->calculateDateDiff($start, $end);
	    
        switch ($unit) {
        	case static::DAYS:
        	    $dateRange = null;
        	    return $dateRange;
        	    break;
        	case static::HOURS:
        	    //Calculate the hours
        	    $hoursFromDays = (new Number($dateInterval->d))->mul(static::HOURS_IN_DAY);
        	    $hours = $hoursFromDays;
        	    
        	    $hours = $hours->add($dateInterval->h);
        	    
        	    $hoursFromMinutes = (new Number($dateInterval->i))->div(static::MINUTES_IN_HOUR);
        	    $hours = $hours->add($hoursFromMinutes);
        	    
        	    $secondsInMinutes = (new Number($dateInterval->i))->div(static::SECONDS_IN_MINUTE);
        	    $hoursFromSeconds = $secondsInMinutes->div(static::MINUTES_IN_HOUR);
        	    $hours = $hours->add($hoursFromSeconds);
        	    
        	    $dateRange = null;
        	    return $dateRange;
        	    break;
        	case static::MINUTES:
        	    $dateRange = null;
        	    return $dateRange;
        	    break;
        	case static::SECONDS:
        	    $dateRange = null;
        	    return $dateRange;
        	    break;
        	default:
        	    throw new InvalidArgumentException(sprintf('Invalid $unit (%s) provided to PrecisionMaths\Utility\DecimalTime::dateRangeAs method', $unit));
        }
	}
	
	protected function isValidUnit($unit)
	{
	    return in_array(strtolower($unit), static::$validUnitsList);
	}
	
	protected function calculateDateDiff(DateTime $start, DateTime $end)
	{
	    $dateInterval = $start->diff($end);

	    return $dateInterval; 
	}
}