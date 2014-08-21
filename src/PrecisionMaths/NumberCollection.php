<?php
namespace PrecisionMaths;

use ArrayObject;

class NumberCollection extends ArrayObject
{
    use \PrecisionMaths\InitialiseNumberTrait;
    
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
    	
    	return $this->initialiseNumber($result);
    }
    
    /**
     * Calculates the mean and returns the value
     * as an instance of number
     * 
     * @return PreciseMaths\Number
     */
    public function mean()
    {
    	return $this->initialiseNumber(bcdiv($this->sum(), count($this)));
    }
    
    public function median()
    {
    	$middleIndex = $this->initialiseNumber(count($this))->div('2').round(0);
    }
    
    public function range()
    {
    	$firstElement = $this->initialiseNumber(end($this));
    	$lastElement = $this->initialiseNumber(reset($this));
    	
    	return $this->initialiseNumber($lastElement->sub($firstElement));
    } 
}