<?php
/* Copyright (c) 2014, 2015 Switch Systems Ltd
 *
* This Source Code Form is subject to the terms of the Mozilla Public
* License, v. 2.0. If a copy of the MPL was not distributed with this
* file, You can obtain one at http://mozilla.org/MPL/2.0/. */

namespace PrecisionMaths;

use ArrayObject;
use RuntimeException;
use Closure;

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
     * Regex pattern to validate value string
     *
     * @var string
     */
    const VALID_STRING_REGEX_PATTERN = '/^\-?\d+(\.\d+)?$/';
    
    /**
     * @param array $array
     * @param string $scale
     */
    public function __construct(array $array, $scale = Number::DEFAULT_SCALE)
    {
        if (! extension_loaded('bcmath')) {
            throw new RuntimeException('BC MATH extension is not loaded');
        }
        
        // Sort, cast to string and validate the array, to ensure future methods work properly
        array_walk($array, function(&$value, $key) {
            $value = (string) $value;
            $this->isValidString($value);
        });

        $this->scale = (int) $scale;
        
    	parent::__construct($array);
    }
    
    /**
     * Checks if value is valid bcmath string
     *
     * @param string $value
     *
     * @return bool
     */
    protected function isValidString($value)
    {
        $matchResult = preg_match(self::VALID_STRING_REGEX_PATTERN, (string) $value);
        
        if ($matchResult === 0 || $matchResult === false) {
            throw new RuntimeException(sprintf('Number::isValid() - Sorry an error occured whilst trying to validate %s', $value));
        }

        return true;
    }
    
    /**
     * Sums the values in the arrays and returns Number object
     * 
     * @param Closure | AnonymousFunction $preSumationCalculation
     * @return PreciseMaths\Number
     */
    public function sum(Closure $preSumationCalculation = null)
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
        $array = $this->getSortedArrayCopy();
        
        $count = new Number(count($array));
        
    	$middleIndex = Number::create($count)->div('2');
    	
    	$median = Number::create($array[$middleIndex->getValueAsInt() - 1]);

    	if ($count->mod('2') != '0') {
    		return Number::create($array[$middleIndex->floor()->getValueAsInt()]);
    	}

    	return Number::create($array[$middleIndex->floor()->getValueAsInt() - 1])->add($array[$middleIndex->ceil()->getValueAsInt() - 1])->div('2', $this->scale);
    }
    
    /**
     * Returns the range for the number collection
     * 
     * @return PrecisionMaths\Number
     */
    public function range()
    {
        $array = $this->getSortedArrayCopy();
        
    	$firstElement = Number::create(reset($array), $this->scale);
    	$lastElement = Number::create(end($array), $this->scale);
    	
    	return Number::create($lastElement->sub($firstElement), $this->scale);
    } 
    
    /**
     * Returns the value of the lower quartile for this collection
     *
     * @return \PrecisionMaths\NumberCollection
     */
    public function lowerQuartile()
    {
        $array = $this->getSortedArrayCopy();
        
        $count = new Number(count($array));
    	$quartilePosition =  $count->add('1')->mul('0.25');
    	
        return $this->calculateQuartileHelper($array, $quartilePosition);
    }
    
    /**
     * Returns the value of the upper quartile for this collection
     *
     * @return \PrecisionMaths\NumberCollection
     */
    public function upperQuartile()
    {
        $array = $this->getSortedArrayCopy();
        
        $count = new Number(count($array));
        $quartilePosition =  $count->add('1')->mul('0.75');

        return $this->calculateQuartileHelper($array, $quartilePosition);
    }
    
    /**
     * This is a helper method to prevent code duplication whilst
     * calculating quartiles
     * 
     * @param array $array 
     * @param integer $positionValue
     * @return \PrecisionMaths\PrecisionMaths\Number
     */
    protected function calculateQuartileHelper(array $array, $positionValue)
    {
        if ($positionValue->isWholeNumber() === true) {
            $quartile = $array[$positionValue->getValueAsInt()];
        } else {
            $quartileCeilPos = $positionValue->ceil()->getValueAsInt() - 1;
            $quartileCeil = new Number($array[$quartileCeilPos]);
        
            $quartileFloorPos = $positionValue->floor()->getValueAsInt() - 1;
            $quartileFloor = new Number($array[$quartileFloorPos]);
             
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
            $value = new Number($value, $this->scale);
            return bcpow(bcsub($value, $mean, $this->scale), '2', $this->scale);
        };
        
        return $this->sum($preSumationCalculation, $this->scale)->div($count, $this->scale);
    }
    
    /**
     * Calculates standard deviation based on sample variance 
     * 
     * @return PrecisionMaths\PrecisionMaths\Number
     */
    public function standardDeviation()
    {
        return $this->variance()->squareroot();
        
    }

    /**
     * Calculates standard deviation based on population variance
     *
     * @return PrecisionMaths\PrecisionMaths\Number
     */
    public function populationStandardDeviation()
    {
         return $this->populationVariance()->squareroot();
    }
    
    /**
     * (non-PHPdoc)
     * @see ArrayObject::append()
     */
    public function append($value)
    {
        $this->isValidString($value);
        parent::append((string) $value);
    }
    
    /**
     * calls getArrayCopy and sorts
     * also rekeys the array
     * 
     * @return array
     */
    public function getSortedArrayCopy()
    {
        $array = parent::getArrayCopy();
        sort($array, SORT_NUMERIC);
        
    	return array_values($array);
    }
}