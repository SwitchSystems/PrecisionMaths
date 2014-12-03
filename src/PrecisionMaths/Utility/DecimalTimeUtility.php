<?php
namespace PrecisionMaths\Utility;

use DateTime;
use InvalidArgumentException;
use PrecisionMaths\Number;
use BadMethodCallException;

/**
 * Utility for precise Decimal Time Calculations
 */
class DecimalTimeUtility
{    
	/**
	 * @var string
	 */
	const MONTHS_IN_YEAR = '12';
	
	/**
	 * @var string
	 */
	const DAYS_IN_YEAR = '365';
		
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
    const MINUTES_IN_HOUR = '60';
    
    /**
     * @var string
     */
    const SECONDS_IN_HOUR = '3600';
    
    /**
     * @var string
     */
    const SECONDS_IN_MINUTE = '60';
        
    
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
     * Gets the number of leap years that occur between the start and end dates.
     * @param DateTime $start
     * @param DateTime $end
     * @return number of leap years
     */
    public function getLeapYears(DateTime $start, DateTime $end)
    {
    	$yearsToCheck = range($start->format('Y'), $end->format('Y'));
    	 
    	$leaps = 0;
    	 
    	foreach($yearsToCheck as $year)
    		if(date('L', strtotime("$year-01-01")))
    			$leaps++;
    	
    	return $leaps;
    }
    
    /**
     * Returns the decimal number of years for a given time period
     *
     * @param DateTime $start
     * @param DateTime $end
     * @return PrecisionMaths\Number
     */
    public function dateRangeAsYears(DateTime $start, DateTime $end)
    {
    	$leaps = $this->getLeapYears($start, $end);
    	    	
    	$dateInterval = $this->calculateDateDiff($start, $end);
    	
    	$daysInYear = $this->calculateAverageDaysInYear($dateInterval->y,$leaps);
    	 
    	$years = new Number($dateInterval->y, $this->scale);
    	 
    	$years = $years->add($this->convertMonthsToYears($dateInterval->m))
    	->add($this->convertDaysToYears($dateInterval->d, $daysInYear))
    	->add($this->convertHoursToYears($dateInterval->h, $daysInYear))
    	->add($this->convertMinutesToYears($dateInterval->i, $daysInYear))
    	->add($this->convertSecondsToYears($dateInterval->s, $daysInYear));
    	 
    	return $years;
    }
    
    /**
     * Returns the average number of days in a year based on total years and number of leap years
     * @param mixed $years the year interval between two dates
     * @param mixed $leaps the number of leap years that occur between the two dates
     */
    public function calculateAverageDaysInYear($years, $leaps)
    {
    	$leapDays = (new Number($leaps, $this->scale))->mul(static::DAYS_IN_YEAR + 1);
    	
    	$nonLeaps = (new Number($years, $this->scale))->sub($leaps);
    	
    	$days = $nonLeaps->mul(static::DAYS_IN_YEAR);
    	
    	$total = $days->add($leapDays);
    	
    	return $total->div($years);
    }
    
    /**
     * Converts decimal months into decimal years
     *
     * @param mixed $months
     * @return PrecisionMaths\Number
     */
    public function convertMonthsToYears($months)
    {
    	return (new Number($months, $this->scale))->div(static::MONTHS_IN_YEAR);
    }
    
    /**
     * Converts decimal days into decimal years
     *
     * @param mixed $days
     * @param mixed $daysInYear
     * @return PrecisionMaths\Number
     */
    public function convertDaysToYears($days, $daysInYear)
    {
    	return (new Number($days, $this->scale))->div($daysInYear);
    }
    
    /**
     * Converts decimal hours into decimal years
     *
     * @param mixed $hours
     * @param mixed $daysInYear
     * @return PrecisionMaths\Number
     */
    public function convertHoursToYears($hours, $daysInYear)
    {
    	return (new Number($hours, $this->scale))->div($daysInYear)->mul(static::HOURS_IN_DAY);
    }
    
    /**
     * Converts decimal minutes into decimal years
     *
     * @param mixed $minutes
     * @param mixed $daysInYear
     * @return PrecisionMaths\Number
     */
    public function convertMinutesToYears($minutes, $daysInYear)
    {
    	return (new Number($minutes, $this->scale))->div($daysInYear)->mul(static::MINUTES_IN_DAY);
    }
    
    /**
     * Converts decimal seconds into decimal years
     *
     * @param mixed $seconds
     * @param mixed $daysInYear
     * @return PrecisionMaths\Number
     */
    public function convertSecondsToYears($seconds, $daysInYear)
    {
    	return (new Number($seconds, $this->scale))->div($daysInYear)->mul(static::SECONDS_IN_DAY);
    }
    
    /**
     * Returns the decimal number of months for a given time period
     *
     * @param DateTime $start
     * @param DateTime $end
     * @return PrecisionMaths\Number
     */
    public function dateRangeAsMonths(DateTime $start, DateTime $end)
    {
    	$leaps = $this->getLeapYears($start, $end);
    	
    	$monthRange = range($start->format('m'), $end->format('m'));
    	
    	$dateInterval = $this->calculateDateDiff($start, $end);
    	 
    	$months = new Number($dateInterval->m, $this->scale);
    	
    	$daysInMonth = $this->calculateAverageDaysInMonth($monthRange, $dateInterval->y,$leaps);
    	
    	$months = $months->add($this->convertYearsToMonths($dateInterval->y))
    	->add($this->convertDaysToMonths($dateInterval->d, $daysInMonth))
    	->add($this->convertHoursToMonths($dateInterval->h, $daysInMonth))
    	->add($this->convertMinutesToMonths($dateInterval->i, $daysInMonth))
    	->add($this->convertSecondsToMonths($dateInterval->s, $daysInMonth));
    	 
    	return $months;
    }
    
    /**
     * Returns the average number of days in a month based on a given array of month,
     * and a total number of years and the number of leap years.
     * @param mixed $months the month interval between two dates as an array, where each element is a month
     * @param mixed $years the year interval between two dates
     * @param mixed $leaps the number of leap years within the year interval
     */
    public function calculateAverageDaysInMonth($months, $years, $leaps)
    {
    	$days = new Number(0, $this->scale);
    	
    	for($years; $years > 0; $years--)
    		for($i = 1; $i <= 12; $i++)
    			$months[] = $i;
    	    		
    	foreach($months as $month)
    	{
    		if(in_array($month,['1','3','5','7','8','10','12']))
    			$days = $days->add('31');
    		elseif($month !== '2')
    			$days = $days->add('30');
    		elseif($leaps > 0)
    		{
    			$days = $days->add('29');
    			$leaps -= 1;
    		}
    		else
    			$days = $days->add('28');
    	}
    	
    	return $days->div(count($months));
    }
    
    /**
     * Converts decimal years into decimal months
     *
     * @param mixed $years
     * @return PrecisionMaths\Number
     */
    public function convertYearsToMonths($years)
    {
    	return (new Number($years, $this->scale))->mul(static::MONTHS_IN_YEAR);
    }
    
    /**
     * Converts decimal days into decimal months
     *
     * @param mixed $days
     * @param mixed $daysInMonth
     * @return PrecisionMaths\Number
     */
    public function convertDaysToMonths($days, $daysInMonth)
    {
    	return (new Number($days, $this->scale))->div($daysInMonth);
    }
    
    /**
     * Converts decimal hours into decimal months
     *
     * @param mixed $hours
     * @param mixed $daysInMonth
     * @return PrecisionMaths\Number
     */
    public function convertHoursToMonths($hours, $daysInMonth)
    {
    	return (new Number($hours, $this->scale))->div($daysInMonth)->mul(static::HOURS_IN_DAY);
    }
    
    /**
     * Converts decimal minutes into decimal months
     *
     * @param mixed $minutes
     * @param mixed $daysInMonth
     * @return PrecisionMaths\Number
     */
    public function convertMinutesToMonths($minutes, $daysInMonth)
    {
    	return (new Number($minutes, $this->scale))->div($daysInMonth)->mul(static::MINUTES_IN_DAY);
    }
    
    /**
     * Converts decimal seconds into decimal months
     *
     * @param mixed $seconds
     * @param mixed $daysInMonth
     * @return PrecisionMaths\Number
     */
    public function convertSecondsToMonths($seconds, $daysInMonth)
    {
    	return (new Number($seconds, $this->scale))->div($daysInMonth)->mul(static::SECONDS_IN_DAY);
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
	    
	    $days = new Number($dateInterval->days, $this->scale);
	    
	    $days = $days->add($this->convertHoursToDays($dateInterval->h))
	                 ->add($this->convertMinutesToDays($dateInterval->i))
	                 ->add($this->convertSecondsToDays($dateInterval->s));
	    
	    return $days;
	}

	/**
	 * Converts decimal hours into decimal days
	 *
	 * @param mixed $hours
	 * @return PrecisionMaths\Number
	 */
	public function convertHoursToDays($hours)
	{
		return (new Number($hours, $this->scale))->div(static::HOURS_IN_DAY);
	}
	
	/**
	 * Converts decimal minutes into decimal days
	 *
	 * @param mixed $minutes
	 * @return PrecisionMaths\Number
	 */
	public function convertMinutesToDays($minutes)
	{
		return (new Number($minutes, $this->scale))->div(static::MINUTES_IN_DAY);
	}
	
	/**
	 * Converts decimal seconds into decimal days
	 *
	 * @param mixed $seconds
	 * @return PrecisionMaths\Number
	 */
	public function convertSecondsToDays($seconds)
	{
		return (new Number($seconds, $this->scale))->div(static::SECONDS_IN_DAY);
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
	    
	    $hours = $this->convertDaysToHours($dateInterval->days)
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
	    
	    $minutes = $this->convertDaysToMinutes($dateInterval->days)
                        ->add($this->convertHoursToMinutes($dateInterval->h))
                        ->add($dateInterval->i)
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
	    
	    $seconds = $this->convertDaysToSeconds($dateInterval->days)
	    				->add($this->convertHoursToSeconds($dateInterval->h))
	                    ->add($this->convertMinutesToSeconds($dateInterval->i))
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