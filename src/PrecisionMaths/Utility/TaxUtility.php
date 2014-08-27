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
    protected $taxRatePercentage;
    
    /**
     * @var string
     */
    protected $scale;
    
    /**
     * @param mixed $taxRatePercentage
     */
    public function __construct($taxRatePercentage, $scale = null)
    {
        // Don't worry about a default scale, let Number class take care of it
        $this->scale = $scale;
        
        $this->taxRatePercentage = new Number($taxRatePercentage, $this->scale);
    }
    
    /**
     * Calculates and returns tax for value
     * 
     * @param mixed $value
     * @return  \PrecisionMaths\Number
     */
    public function fetchValueOfTaxToBeAdded($value)
    {
        return $this->taxRatePercentage->div('100')->mul($value);
    }
	
    /**
     * Calculates and returns the proportion of the value that is tax
     * 
     * @param mixed $value
     * @return  \PrecisionMaths\Number
     */
    public function fetchValueOfAddedTax($value)
    {
        return Number::create($value, $this->scale)->sub($this->removeTaxFrom($value));
    }
    
	/**
	 * Calculates and returns the value with tax
	 * 
	 * @param mixed $value
	 * @return Number
	 */
	public function addTaxTo($value)
	{
	    $tax = $this->fetchValueOfTaxToBeAdded($value);
	    
	    return $tax->add($value);
	}
	
	/**
	 * Calculates and returns the value before tax was added
	 * 
	 * @param mixed $value
	 * @return Number
	 */
	public function removeTaxFrom($value)
	{
	    return Number::create($value, $this->scale)->div($this->taxRatePercentage->add('100'))->mul('100');
	}
}