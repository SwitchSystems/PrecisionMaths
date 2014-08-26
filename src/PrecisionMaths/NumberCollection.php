<?php
namespace PrecisionMaths;

use ArrayObject;
use RuntimeException;

/**
 * Class to wrap array with methods 
 * to perform operation on self
 */
class NumberCollection extends ArrayObject
{
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
        if (! extension_loaded('bcmath')) {
            throw new RuntimeException('BC MATH extension is not loaded');
        }
        
        // Sort the array, to ensure future methods work properly
    	sort($array);

        if ($scale === null) { 
            $this->scale = Number::DEFAULT_SCALE;
        } else {
            $this->scale = (int) $scale;
        }
             
    	parent::__construct($array);
    }
    
    /**
     * Sums the values in the arrays and returns Number object
     * 
     * @param integer $preSumationCalculation
     * @return PreciseMaths\Number
     */
    public function sum($preSumationCalculation = null)
    {
    	$result = '0';

    	foreach ($this as $value) {
            if ($preSumationCalculation !== null) { 
    	       $result = bcadd($result, $preSumationCalculation($value), $this->scale);
            } else {
                $result = bcadd($result, $value, $this->scale);
            }
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
        $count = new Number(count($this));
        
    	$middleIndex = Number::create($count)->div('2').round(0);
    	$median = $this[$middleIndex->getValueAsInt()];
    	if ($count->mod('2')->isWholeNumber() === false) {
    		return $median;
    	}
    	
        return $median->add($this[$middleIndex->getValueAsInt() + 1])->div('2');
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
    	$quartilePosition =  $count->add('1')->mul('0.25');
    	
        return $this->calculateQuartileHelper($quartilePosition);
    }
    
    /**
     * Returns the value of the upper quartile for this collection
     *
     * @return \PrecisionMaths\NumberCollection
     */
    public function upperQuartile()
    {
        $count = new Number(count($this));
        $quartilePosition =  $count->add('1')->mul('0.75');

        return $this->calculateQuartileHelper($quartilePosition);
    }
    
    /**
     * This is a helper method to prevent code duplication whilst
     * calculating quartiles
     * 
     * @param unknown $positionValue
     * @return \PrecisionMaths\PrecisionMaths\Number
     */
    protected function calculateQuartileHelper($positionValue)
    {
        if ($positionValue->isWholeNumber() === true) {
            $quartile = $this[$positionValue->getValueAsInt()];
        } else {
            $quartileCeilPos = $positionValue->ceil()->getValueAsInt() - 1;
            $quartileCeil = new Number($this[$quartileCeilPos]);
        
            $quartileFloorPos = $positionValue->floor()->getValueAsInt() - 1;
            $quartileFloor = new Number($this[$quartileFloorPos]);
             
            $quartile = $quartileCeil->add($quartileFloor)->div('2');
        }
        
        return $quartile;
    }
    
    /**
     * Calculates and returns the Interquartile Range
     * 
     * @return \PrecisionMaths\Number
     */
    public function interquartileRange()
    {
        $lowerQuartile = $this->lowerQuartile();
        $upperQuartile = $this->upperQuartile();	
        
        return $upperQuartile->sub($lowerQuartile);
    }
 
    /**
     * Calculates the variance for population
     * 
     * Σ(X - μ)²
     * ‾‾‾‾‾‾‾‾
     *    n
     *  
     * @return PrecisionMaths\Number
     */
    public function populationVariance()
    {
        return $this->calculateVarianceHelper(count($this));
        
    }
    
    /**
     * Calculates the variance for sample
     * 
     * Σ(X - x̄)²
     * ‾‾‾‾‾‾‾‾
     *  n - 1
     *  
     *  
     * @return PrecisionMaths\Number
     */
    public function variance()
    {
        return $this->calculateVarianceHelper(count($this) - 1);
    
    }
    
    /**
     * Helper method for code reuse across 
     * variance methods
     * 
     * @param integer $count
     * @return PrecisionMaths\PrecisionMaths\Number
     */
    protected function calculateVarianceHelper($count)
    {
        $mean = $this->mean();
         
        $preSumationCalculation = function($value) use ($mean) {
            $value = new Number($value);
            return bcpow(bcsub($value, $mean, $this->scale), '2', $this->scale);
        };
        
        return $this->sum($preSumationCalculation)->div($count);
    }
    
    /**
     * Calculates standard deviation bassed on sample variance 
     * 
     * @return PrecisionMaths\PrecisionMaths\Number
     */
    public function standardDeviation()
    {
        return $this->variance()->squareroot();
        
    }

    /**
     * Calculates standard deviation bassed on population variance
     *
     * @return PrecisionMaths\PrecisionMaths\Number
     */
    public function populationStandardDeviation()
    {
         return $this->populationVariance()->squareroot();
    }
}