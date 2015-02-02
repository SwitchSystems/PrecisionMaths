<?php
/* Copyright (c) 2014, 2015 Switch Systems Ltd
 *
* This Source Code Form is subject to the terms of the Mozilla Public
* License, v. 2.0. If a copy of the MPL was not distributed with this
* file, You can obtain one at http://mozilla.org/MPL/2.0/. */

namespace PrecisionMaths;

use InvalidArgumentException;
use RuntimeException;

/**
 * Immutable Number which wraps the basic operations of BC MATH
 * and provideds some additional operations
 */
class Number
{
    /**
     * Default scale for BC MATH operation
     *
     * @var integer
     */
    const DEFAULT_SCALE = 20;
    
    /**
     * Regex pattern to validate value string
     *
     * @var string
     */
    const VALID_STRING_REGEX_PATTERN = '/^\-?\d+(\.\d+)?$/';
    
    protected static $validTypesList = [
	    'integer',
	    'string',
	    'double',
	    'object'
    ];
    
    /**
     * @var string
     */
    protected $value;

    /**
     * Scale to use for BC MATH Operations
     *
     * @var integer
     */
    protected $scale;
    
    /**
     * Number constructor
     *
     * @param string $value
     */
    public function __construct($value, $scale = self::DEFAULT_SCALE)
    {
        if (! extension_loaded('bcmath')) {
            throw new RuntimeException('BC MATH extension is not loaded');
        }
        
        $this->checkValueIsValid($value);
        $this->scale = (int) $scale;
        $this->value = (string) $value;
    }

    /**
     * Adds $rightOperand value to current value and retuns calculated
     * value as new instance of Number
     * 
     * @link http://php.net/manual/en/function.bcadd.php
     * @param mixed $rightOperand
     * @param integer $scale
     * @return PrecisionMaths\Number
     */
    public function addition($rightOperand, $scale = null)
    {
        $this->checkValueIsValid($rightOperand);
        
        if ($scale === null) {
        	$scale = $this->scale;
        }
        
        $result = bcadd($this, $rightOperand, $scale);
        return self::create($result, $scale);
    }
    
    /**
     * Alias for addition
     * 
     * @see self::addition()
     * @param mixed $rightOperand
     * @param integer $scale
     * @return \PrecisionMaths\PrecisionMaths\Number
     */
    public function add($rightOperand, $scale = null)
    {
        return $this->addition($rightOperand, $scale);
    }
    
    /**
     * Subtracts $rightOperand value from current value and retuns calculated
     * value as new instance of Number
     *
     * @link http://php.net/manual/en/function.bcsub.php
     * @param mixed $rightOperand
     * @param integer $scale
     * @return PrecisionMaths\Number
     */
    public function subtract($rightOperand, $scale = null)
    {
        $this->checkValueIsValid($rightOperand);
        
        if ($scale === null) {
            $scale = $this->scale;
        }

        $result = bcsub($this, $rightOperand, $scale);
        return self::create($result, $scale);
    }
    
    /**
     * Alias for subtract
     *
     * @see self::subtract()
     * @param mixed $rightOperand
     * @param integer $scale
     * @return \PrecisionMaths\PrecisionMaths\Number
     */
    public function sub($rightOperand, $scale = null)
    {
        return $this->subtract($rightOperand, $scale);
    }
    
    /**
     * Multiplies $rightOperand value by current value and retuns calculated
     * value as new instance of Number
     * 
     * @link http://php.net/manual/en/function.bcmul.php
     * @param mixed $rightOperand
     * @param integer $scale
     * @return PrecisionMaths\Number
     */
    public function multiply($rightOperand, $scale = null)
    {
        $this->checkValueIsValid($rightOperand);
        
        if ($scale === null) {
            $scale = $this->scale;
        }
        
        $result = bcmul($this, $rightOperand, $scale);
        return self::create($result, $scale);
    }
    
    /**
     * Alias for multiply
     *
     * @see self::multiply()
     * @param mixed $rightOperand
     * @param integer $scale
     * @return \PrecisionMaths\PrecisionMaths\Number
     */
    public function mul($rightOperand, $scale = null)
    {
        return $this->multiply($rightOperand, $scale);
    }
    
    /**
     * Divides current value by $rightOperand value and retuns calculated
     * value as new instance of Number
     *
     * @link http://php.net/manual/en/function.bcdiv.php
     * @param mixed $rightOperand
     * @param integer $scale
     * @return PrecisionMaths\Number
     */
    public function divide($rightOperand, $scale = null)
    {
        $this->checkValueIsValid($rightOperand);
        if ($scale === null) {
            $scale = $this->scale;
        }
        
        $result = bcdiv($this, $rightOperand, $scale);
        return self::create($result, $scale);
    }
    
    /**
     * Alias for divide
     *
     * @see self::divide()
     * @param mixed $rightOperand
     * @param integer $scale
     * @return \PrecisionMaths\PrecisionMaths\Number
     */
    public function div($rightOperand, $scale = null)
    {
        return $this->divide($rightOperand, $scale);
    }

    /**
     * Calculates and returns modulus
     * value as new instance of Number
     *
     * @link http://php.net/manual/en/function.bcmod.php
     * @param mixed $rightOperand
     * @return PrecisionMaths\Number
     */
    public function modulus($modulus)
    {
        $this->checkValueIsValid($modulus);
        
        return self::create(bcmod($this, $modulus));
    }
    
    /**
     * Alias for modulus
     *
     * @see self::modulus()
     * @param mixed $modulus
     * @return \PrecisionMaths\PrecisionMaths\Number
     */
    public function mod($modulus)
    {
        return $this->modulus($modulus);
    }
    
    /**
     * Raises this by $rightOperand
     * value and returns as new instance of Number
     *
     * @link http://php.net/manual/en/function.bcpow.php
     * @param mixed $rightOperand
     * @param integer $scale
     * @return PrecisionMaths\Number
     */
    public function power($rightOperand, $scale = null)
    {
        $this->checkValueIsValid($rightOperand);
        
        if ($scale === null) {
            $scale = $this->scale;
        }
        
        $result = bcpow($this, $rightOperand, $scale);

        return self::create($result, $scale);
    }
    
    /**
     * Alias for power
     *
     * @see self::power()
     * @param mixed $power
     * @param integer $scale
     * @return \PrecisionMaths\PrecisionMaths\Number
     */
    public function pow($rightOperand, $scale = null)
    {
        return $this->power($rightOperand, $scale);
    }
    
    /**
     * Raise number by $rightOperand, and reduced by a $modulus
     * value and returns as new instance of Number
     *
     * @link http://php.net/manual/en/function.bcpowmod.php
     * @param mixed $rightOperand
     * @param integer $scale
     * @return PrecisionMaths\Number
     */
    public function powerModulus($rightOperand, $modulus, $scale = null)
    {
        $this->checkValueIsValid($rightOperand);
        $this->checkValueIsValid($modulus);
        
        if ($scale === null) {
            $scale = $this->scale;
        }
        
        $result = bcpowmod($this, $rightOperand, $modulus, $scale);
        return self::create($result, $scale);
    }
    
    /**
     * Alias for powerModulus
     *
     * @see self::powerModulus()
     * @param mixed $rightOperand
     * @param mixed $modulus
     * @param integer $scale
     * @return \PrecisionMaths\PrecisionMaths\Number
     */
    public function powmod($rightOperand, $modulus, $scale = null)
    {
        return $this->powermodulus($rightOperand, $modulus, $scale);
    }
    
    /**
     * Returns the square root of the number as a new
     * instance of number
     *
     * @link http://php.net/manual/en/function.bcsqrt.php
     * @param mixed $rightOperand
     * @param integer $scale
     * @return PrecisionMaths\Number
     */
    public function squareroot($scale = null)
    {
        if ($scale === null) {
            $scale = $this->scale;
        }
        
        $result = bcsqrt($this, $scale);
        return self::create($result, $scale);
    }
    
    /**
     * Alias for squareroot
     *
     * @see self::squareroot()
     * @param integer $scale
     * @return \PrecisionMaths\PrecisionMaths\Number
     */
    public function sqrt($scale = null)
    {
        return $this->squareroot($scale);
    }
    
    /**
     * Compares this by $right operand
     * Returns 0 if the two operands are equal, 1 if the left_operand is larger than the right_operand, -1 otherwise.
     * 
     * @link http://php.net/manual/en/function.bccomp.php
     * @param mixed $rightOperand
     * @param integer $scale
     * 
     * @return integer
     */
    public function compare($rightOperand, $scale = null)
    {
        $this->checkValueIsValid($rightOperand);
        
        if ($scale === null) {
            $scale = $this->scale;
        }
        
        return bccomp($this, $rightOperand, $scale);
    }
    
    /**
     * Alias for compare
     *
     * @see self::compare()
     * @param mixed $rightOperand
     * @param integer $scale
     * 
     * @return integer
     */
    public function comp($rightOperand, $scale = null)
    {
        if ($scale === null) {
            $scale = $this->scale;
        }
        
        return $this->compare($rightOperand, $scale);
    }
    
    /**
     * Returns true if this number is less than 
     * the value provided to $rightOperand Arg
     *
     * @param mixed $rightOperand
     * @param integer $scale
     * @return Boolean
     */
    public function lessThan($rightOperand, $scale = null)
    {
        $this->checkValueIsValid($rightOperand);
        
        if ($scale === null) {
            $scale = $this->scale;
        }
    	if (bccomp($this, $rightOperand, $scale) === -1) {
    		return true;
    	} else {
        	return false;
        }
    }
    
    /**
     * Alias for lessThan
     *
     * @see self::lessThan()
     * @param mixed $rightOperand
     * @param integer $scale
     * @return Boolean
     */
    public function lt($rightOperand, $scale = null)
    {
    	return $this->lessThan($rightOperand, $scale);
    }
    
    /**
     * Returns true if this number is greater than
     * the value provided to $rightOperand Arg
     *
     * @param mixed $rightOperand
     * @param integer $scale
     * @return Boolean
     */
    public function greaterThan($rightOperand, $scale = null)
    {
        $this->checkValueIsValid($rightOperand);

        if ($scale === null) {
            $scale = $this->scale;
        }
        
        if (bccomp($this, $rightOperand, $scale) === 1) {
            return true;
        } else {
        	return false;
        }
    }
    
    /**
     * Alias for greaterThan
     *
     * @see self::greaterThan()
     * @param mixed $rightOperand
     * @param integer $scale
     * @return Boolean
     */
    public function gt($rightOperand, $scale = null)
    {
        return $this->greaterThan($rightOperand, $scale);
    }
    
    /**
     * Floors the number and returns as a new instance of Number
     * 
     * @return \PrecisionMaths\Number
     */
    public function floor()
    {
        $result = self::create(bcmul($this, '1', 0));
        
        if ($this->isNegative()) {
            $result = $result->sub('1', 0);
        }
        
        return self::create($result, 0);
    }
    
    /**
     * Ceils the number and returns as a new instance of Number
     *
     * @return \PrecisionMaths\Number
     */
    public function ceil()
    {
        if ($this->isNegative()) {
            $result = bcmul($this, '1', 0);
            
            return self::create($result, 0);
        } else {
            $floor = $this->floor();
            return self::create($floor->add('1', 0));
        }
    }
    
    /**
     * Rounds the number as per php round function
     * this method DOES NOT use arbitrary precision style rounding
     * but Number::round does
     *
     * @see http://php.net/manual/en/function.round.php
     * @param integer $precision
     * @param unknown $type
     * @return Ambigous <\PrecisionMaths\Number, \PrecisionMaths\Number>
     */
    public function impreciseRound($precision, $type = null)
    {
        return self::create(round((string) $this, $precision, $type));
    }

    /**
     * Rounds the number as per php number_format function
     * this method DOES NOT use arbitrary precision style rounding
     * but Number::round does
     *
     * @see @link http://php.net/manual/en/function.number-format.php
     * @param integer $precision
     * @return Ambigous <\PrecisionMaths\Number, \PrecisionMaths\Number>
     */
    public function numberFormat($precision)
    {
        return self::create(number_format((float) (string) $this, $precision));
    }

    /**
     * Chops the end of after precision significant figure has been reached
     * 
     * @param integer $precision
     * @return PrecisionMaths\Number
     */
    public function round($precision)
    {
    	return self::create($this->mul('1', $precision));
    }
    
    /**
     * Returns true if this is a negative number
     * otherwise returns false
     * 
     * @return boolean
     */
    public function isNegative()
    {
    	if (substr($this, 0, 1) === '-') {
    	   return true;
    	}
    	
    	return false;
    }
    
    /**
     * Here there be magic...
     * 
     * @see http://php.net/manual/en/language.oop5.magic.php#object.tostring
     * @return string
     */
	public function __toString() 
	{
		return (string) $this->value;
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
    	switch (preg_match(self::VALID_STRING_REGEX_PATTERN, (string) $value)) {
    	   case 0:
    	       return false;
    	       break; 
    	   case 1:
    	       return true;
               break;
    	   default:
    	       throw new RuntimeException(sprintf('Number::isValid() - Sorry an error occured whilst trying to validate %s', $value));
    	}
    }
    
    /**
     * @param mixed $value
     * @throws InvalidArgumentException
     */
    protected function checkValueIsValid($value)
    {
        if ((! $this->isValidType($value)) || (! $this->isValidString($value))) {
            throw new InvalidArgumentException(sprintf('The value %s provided is not valid', $value));
        }
    }
    
    /**
     * Checks type of $value and returns true if is otherwise throws exception
     *
     * @param mixed $value
     * @return bool
     */
    protected function isValidType($value)
    {
        if (in_array(gettype($value), static::$validTypesList)) {
            return true;
        } elseif ($value instanceof Number) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Factory method to create a new instance 
     * 
     * @param mixed $value
     * @return \PrecisionMaths\Number
     */
    public static function create($value, $scale = null)
    {
    	return new static($value, $scale);
    }
    
    /**
     * returns the scale 
     * 
     * @return number
     */
    public function getScale()
    {
    	return $this->scale;
    }
    
    /**
     * Returns this value as an integer
     * This obviously is going to truncate your number if it isn't a whole number
     * 
     * @return number
     */
    public function getValueAsInt()
    {
        return (int) $this->value;	
    }
    
    /**
     * Returns this value as an float
     * This is going to truncate precision greater than
     * than float max 
     *
     * @deprecated deprecated since version 0.3.0
     * @return number
     */
    public function getValueAsFloat($precision = self::DEFAULT_SCALE)
    {
        return (float) (string) $this->impreciseRound($precision);
    }

    /**
     * Converts value to float
     * Precision may be lost when using this method
     *
     * @return number
     */
    public function convertToFloat()
    {
        return (float) (string) $this;
    }

    /**
     * Checks if value is a whole number
     * 
     * @return boolean
     */
    public function isWholeNumber()
    {
        $decimalPointPosition = strpos($this, '.');

        if ($decimalPointPosition !== false) {
            $mantissa = substr($this, $decimalPointPosition + 1);

            $matchResult = preg_match('/[^0]/', $mantissa);
            
            if ($matchResult === 1) {
            	return false;
            } elseif ($matchResult === 0) {
            	return true;
            } else {
            	throw new InvalidArgumentException('There was an error checking if whole number');
            }
            
        } else {
        	return true;
        }
    }
}