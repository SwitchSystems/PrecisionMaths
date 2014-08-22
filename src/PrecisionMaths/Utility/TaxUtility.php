<?php
namespace PrecisionMaths\Utility;

use RuntimeException;
use PrecisionMaths\Number;

/**
 *  Utility Class to calculate tax 
 */
class TaxUtility
{
    /**
     * Current Tax Rate
     * @var float
     */
    protected $taxRate;
    
    /**
     * @var string
     */
    protected $scale;
    
    /**
     * @param mixed $taxRate
     */
    public function __construct($taxRate, $scale = null)
    {
        // Don't worry about a default scale, let Number class take care of it
        $this->scale = $scale;
        
        $this->taxRate = new Number($taxRate, $this->scale);
    }
    
    /**
     * Calculate and return tax for a given value
     * 
     * @param mixed $value
     */
	public function calculateTaxAmountOnGross($value)
	{
		$numberObj = Number::create($value, $this->scale);

		return $this->taxRate->div('100')->mul($numberObj);
	}
	
	/**
	 * Returns the value of the tax that has been added to the value
	 *
	 * @param mixed $value
	 * @return Number
	 */
	public function calculateTaxAmountFromNet($value)
	{
	    $numberObj = Number::create($value, $this->scale);
	    $gross = $this->calculateGrossFromNet($value);
	    
	    //return $numberObj->sub($gross);
	    return $gross->sub($value);
	    /*
	    $numberObj = Number::create($value, $this->scale);
	    $onePercentOfValue = $numberObj->div($this->taxRate->add('100'));
	    
	    return $numberObj->sub($onePercentOfValue->mul('100'));*/
	}
	
	/**
	 * Calculates the Gross value
	 * 
	 * @param mixed $value
	 * @return Number
	 */
	public function calculateGrossFromNet($value)
	{
	    $numberObj = Number::create($value, $this->scale);
	
	    $tax = $this->taxRate->div('100')->mul($numberObj);
	    
	    return $tax->add($numberObj);
	}
	
	/**
	 * Calculates the Net value 
	 * 
	 * @param mixed $value
	 * @return Number
	 */
	public function calculateNetFromGross($value)
	{
	    $numberObj = Number::create($value, $this->scale);
	    $onePercentOfValue = $numberObj->div($this->taxRate->add('100'));
	    
	    return $onePercentOfValue->mul('100');
	}
}