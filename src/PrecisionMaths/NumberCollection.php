<?php
namespace PrecisionMaths;

use ArrayObject;

/**
 * Class to wrap array with methods 
 * to perform operation on self
 */
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
    
    /**
     * @param array $array
     * @param string $scale
     */
    public function __construct(array $array, $scale = null)
    {
        // Sort the array, to ensure future methods work properly
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
    	    $result = bcadd($result, $value, $this->scale);
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
    	return Number::create(bcdiv($this->sum(), count($this), $this->scale));
    }
    
    /**
     * Returns the median of the collection
     * 
     * @return \PrecisionMaths\NumberCollection
     */
    public function median()
    {
    	$middleIndex = Number::create(count($this))->div('2').round(0);
    
        return $this[$middleIndex->getValueAsInt()];
    }
    
    /**
     * Returns the range for the number collection
     * 
     * @return PrecisionMaths\Number
     */
    public function range()
    {
    	$firstElement = Number::create(reset($this));
    	$lastElement = Number::create(end($this));
    	
    	return Number::create($lastElement->sub($firstElement));
    } 
    
    /**
     * Returns the value of the lower quartile for this collection
     *
     * @return \PrecisionMaths\NumberCollection
     */
    public function lowerQuartile()
    {
        $count = new Number(count($this));
    	$position =  $count->sub('1')->mul('0.25')->floor()->add('1');

    	return $this[$position->getValueAsInt()];
    }
}