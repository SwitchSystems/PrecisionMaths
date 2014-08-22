<?php
namespace PrecisionMaths\Utility;

use DateTime;
use InvalidArgumentException;
use PrecisionMaths\Number;
use BadMethodCallException;

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

    /**
     * @var string
     */
    const SECONDS_IN_DAY = '86400';
    
    /**
     * @var string
     */
    const SECONDS_IN_HOUR = '3600';
    
    /**
     * @var string
     */
    protected $scale;
    
    /**
     * @param string $scale
     */
    public function __construct($scale = null)
    {
        // Don't worry about a default scale, let Number class take care of it
        $this->scale = $scale;
    }
    
    /**
     * Returns the decimal number of days for a given time period
     * 
     * @param DateTime $start
     * @param DateTime $end
     * @return PrecisionMaths\Number
     */
	public function dateRangeAsDays(DateTime $start, DateTime $end)
	{
	    $dateInterval = $this->calculateDateDiff($start, $end);
	    
	    // Calculate the days and assign to $days
	    $days = new Number($dateInterval->h, $this->scale);
	    
	    // Calculate days from hours and add to $days 
	    $daysFromHours = (new Number($dateInterval->h, $this->scale))->div(static::HOURS_IN_DAY);
	    $days = $days->add($daysFromHours);
	    
	    // Calculate days from Minutes 
	    $daysFromMinutes = (new Number($dateInterval->i, $this->scale))->div(static::MINUTES_IN_DAY);
	    $days = $days->add($daysFromMinutes);
	    
	    // Calculate days from seconds and add to $days
	    $daysFromSeconds = (new Number($dateInterval->s, $this->scale))->div(static::SECONDS_IN_DAY);
	    $days = $days->add($daysFromSeconds);
	    
	    return $days;
	}

	/**
	 * Returns decimal hours based on DateInterval d, h, i and s properties
	 * 
	 * @param DateTime $start
	 * @param DateTime $end
	 * @return PrecisionMaths\Number
	 */
	public function dateRangeAsHours(DateTime $start, DateTime $end)
	{
	    $dateInterval = $this->calculateDateDiff($start, $end);
	    
	    $hours = $this->convertDaysToHours($dateInterval->d)
	                  ->add($dateInterval->h)
	                  ->add($this->convertMinutesToHours($dateInterval->i))
	                  ->add($this->convertSecondsToHours($dateInterval->s));
	    
	    return $hours;
	}
	
	/**
	 * Converts decimal days into decimal hours
	 *
	 * @param mixed $days
	 * @return PrecisionMaths\Number
	 */
	public function convertDaysToHours($days)
	{
		return (new Number($days, $this->scale))->mul(static::HOURS_IN_DAY);
	}

	/**
	 * Converts decimal minutes into decimal hours
	 *
	 * @param mixed $minutes
	 * @return PrecisionMaths\Number
	 */
	public function convertMinutesToHours($minutes)
	{
		return (new Number($minutes, $this->scale))->div(static::MINUTES_IN_HOUR);
	}
	
	/**
	 * Converts decimal seconds into decimal hours
	 * 
	 * @param mixed $seconds
	 * @return PrecisionMaths\Number
	 */
	public function convertSecondsToHours($seconds)
	{
		return (new Number($seconds, $this->scale))->div(static::SECONDS_IN_HOUR);
	}
	
	/**
	 * Returns decimal minutes based on DateInterval d, h, i and s properties
	 *
	 * @param DateTime $start
	 * @param DateTime $end
	 * @return PrecisionMaths\Number
	 */
	public function dateRangeAsMinutes(DateTime $start, DateTime $end)
	{
	    $dateInterval = $this->calculateDateDiff($start, $end);
	    
	    $minutes = $this->convertDaysToMinutes($dateInterval->d)
                        ->add($dateInterval->i)
                        ->add($this->convertHoursToMinutes($dateInterval->h))
                        ->add($this->convertSecondsToMinutes($dateInterval->s));
	    
	    return $minutes;
	}

	/**
	 * Converts decimal days to decimal minutes
	 *
	 * @param mixed $seconds
	 * @return \PrecisionMaths\Number
	 */
	public function convertDaysToMinutes($days)
	{
		return (new Number($days, $this->scale))->mul(static::MINUTES_IN_DAY);
	}
	
	/**
	 * Converts decimal hours to decimal minutes
	 *
	 * @param mixed $seconds
	 * @return \PrecisionMaths\Number
	 */
	public function convertHoursToMinutes($hours)
	{
		return (new Number($hours, $this->scale))->mul(static::MINUTES_IN_HOUR);
	}
	
	/**
	 * Converts decimal seconds to decimal minutes
	 * 
	 * @param mixed $seconds
	 * @return \PrecisionMaths\Number
	 */
	public function convertSecondsToMinutes($seconds)
	{
		return (new Number($seconds, $this->scale))->div(static::SECONDS_IN_MINUTE);
	}
	
	/**
	 * Returns decimal seconds from the range provided
	 * 
	 * @param DateTime $start
	 * @param DateTime $end
	 * @return PrecisionMaths\Number
	 */
	public function dateRangeAsSeconds(DateTime $start, DateTime $end)
	{
	    $dateInterval = $this->calculateDateDiff($start, $end);
	    
	    $seconds = $this->convertDaysToSeconds($dateInterval->d)
	                    ->add($this->convertMinutesToSeconds($dateInterval->i))
	                    ->add($this->convertHoursToSeconds($dateInterval->h))
	                    ->add($dateInterval->s);
	
	    return $seconds;
	}

	/**
	 * Converts a decimal days value into a decimal seconds value
	 *
	 * @param mixed $days
	 * @return \PrecisionMaths\Number
	 */
	public function convertDaysToSeconds($days)
	{
		return (new Number($days, $this->scale))->mul(static::SECONDS_IN_DAY);
	}
	
	/**
	 * Converts a decimal hours value into a decimal seconds value
	 *
	 * @param mixed $hours
	 * @return \PrecisionMaths\Number
	 */
	public function convertHoursToSeconds($hours)
	{
		return (new Number($hours, $this->scale))->mul(static::SECONDS_IN_HOUR);
	}
	
	/**
	 * Converts a decimal minutes value into a decimal seconds value
	 * 
	 * @param mixed $minutes
	 * @return \PrecisionMaths\Number
	 */
	public function convertMinutesToSeconds($minutes)
	{
		return (new Number($minutes, $this->scale))->mul(static::SECONDS_IN_MINUTE);
	}
	
	/**
	 * Calculates the date interval for the range
	 * 
	 * @param DateTime $start
	 * @param DateTime $end
	 * @throws BadMethodCallException
	 * @return \DateInterval
	 */
	protected function calculateDateDiff(DateTime $start, DateTime $end)
	{
	    $dateInterval = $start->diff($end);

	    // This utility is not handling inverse time periods 
	    if ($dateInterval->invert === 1) {
	    	throw new BadMethodCallException('Start Date must be before end date!');
	    }
	    
	    return $dateInterval; 
	}
}