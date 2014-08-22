<?php
namespace PrecisionMaths\Utility;

use RuntimeException;

class Tax
{
    /**
     * Current Tax Rate
     * @var float
     */
    protected $taxRate;
    
    public function __construct($taxRate)
    {
        $this->taxRate = $taxRate;
    }
    
	public function calculateTax($value)
	{
		$numberObj = Number::create($value);

		return $this->taxRate->div('100')->mul($numberObj);
	}

	/**
	 * Returns value with tax added
	 * 
	 * @param mixed $value
	 * @return Number
	 */
	public function addTaxTo($value)
	{
	    $numberObj = Number::create($value);
	
	    $tax = $this->taxRate->div('100')->mul($numberObj);
	    
	    return $tax->add($numberObj);
	}
	
	/**
	 * Returns the value with tax removed
	 * 
	 * @param mixed $value
	 * @return Number
	 */
	public function removeTaxFrom($value)
	{
	    $numberObj = Number::create($value);
	    $onePercentOfValue = $numberObj->div($this->taxRate->add('100'));
	    
	    return $onePercentOfValue->mul('100');
	}
}