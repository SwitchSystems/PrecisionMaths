<?php
/* Copyright (c) 2014, 2015 Switch Systems Ltd
 *
* This Source Code Form is subject to the terms of the Mozilla Public
* License, v. 2.0. If a copy of the MPL was not distributed with this
* file, You can obtain one at http://mozilla.org/MPL/2.0/. */

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
    public function __construct($taxRatePercentage, $scale = Number::DEFAULT_SCALE)
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