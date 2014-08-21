<?php
namespace PrecisionMaths;

use RuntimeException;

class Tax
{
    use PrecisionMaths\InitialiseNumberTrait;
    
    public static $validTypesList = [
	    'integer',
	    'string',
	    'double'
    ];
    
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
		$numberObj = $this->initialiseNumber($value);

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
	    $numberObj = $this->initialiseNumber($value);
	
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
	    $numberObj = $this->initialiseNumber($value);
	    $onePercentOfValue = $numberObj->div($this->taxRate->add('100'));
	    
	    return $onePercentOfValue->mul('100');
	}
}