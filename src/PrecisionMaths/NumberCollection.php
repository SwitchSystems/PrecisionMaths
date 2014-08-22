<?php
namespace PrecisionMaths;

use ArrayObject;

class NumberCollection extends ArrayObject
{
    /**
     * Default scale for BC MATH operation
     * 
     * @var integer
     */
    const DEFAULT_SCALE = 20;
    
    /**
     * @var integer
     */
    protected $scale;
    
    public function __construct(array $array, $scale = null)
    {
    	sort($array);

        if ($scale !== null) { 
            $this->scale = (int) $scale;
        } else {
            $this->scale = self::DEFAULT_SCALE;	
        }
        
    	parent::__construct($array);
    }
    
    /**
     * Sums the values in the arrays and returns Number object
     * 
     * @return PreciseMaths\Number
     */
    public function sum()
    {
    	$result = '0';
    	
    	foreach ($this as $value) {
    	    $result = bcadd($result, $value);
    	}
    	
    	return Number::create($result);
    }
    
    /**
     * Calculates the mean and returns the value
     * as an instance of number
     * 
     * @return PreciseMaths\Number
     */
    public function mean()
    {
    	return Number::create(bcdiv($this->sum(), count($this)));
    }
    
    public function median()
    {
    	$middleIndex = Number::create(count($this))->div('2').round(0);
    }
    
    public function range()
    {
    	$firstElement = Number::create(end($this));
    	$lastElement = Number::create(reset($this));
    	
    	return Number::create($lastElement->sub($firstElement));
    } 
}