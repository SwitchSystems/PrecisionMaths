<?php
namespace PrecisionMaths;

use InvalidArgumentException;
use RuntimeException;

/**
 * Immutable Number which wraps the basic operations of BC MATH
 * and provideds some additional operations
 */
class Number
{
    protected static $validTypesList = [
	    'integer',
	    'string',
	    'double'
    ];
    
    /**
     * Default scale for BC MATH operation
     * 
     * @var integer
     */
    const DEFAULT_SCALE = 20;
    
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
    public function __construct($value, $scale = null)
    {
        if ((! $this->isValidType($value)) || (! $this->isValidString($value))) {
            throw new InvalidArgumentException(sprintf('The value %s provided is not valid', $value));
        }
        
        if ($scale !== null) { 
            $this->scale = (int) $scale;
        } else {
            $this->scale = self::DEFAULT_SCALE;	
        }
        
        $this->value = (string) $value;
    }

    /**
     * Adds $rightOperand value to current value and retuns calculated
     * value as new instance of Number
     * 
     * @param mixed $rightOperand
     * @return PrecisionMaths\Number
     */
    public function addition($rightOperand)
    {
        return self::create(bcadd($this, $rightOperand, $this->scale));
    }
    
    /**
     * Alias for addition
     * 
     * @see self::addition()
     * @param mixed $rightOperand
     * @return \PrecisionMaths\PrecisionMaths\Number
     */
    public function add($rightOperand)
    {
        return $this->addition($rightOperand);
    }
    
    /**
     * Subtracts $rightOperand value from current value and retuns calculated
     * value as new instance of Number
     *
     * @param mixed $rightOperand
     * @return PrecisionMaths\Number
     */
    public function subtract($rightOperand)
    {
        return self::create(bcsub($this, $rightOperand, $this->scale));
    }
    
    /**
     * Alias for subtract
     *
     * @see self::subtract()
     * @param mixed $rightOperand
     * @return \PrecisionMaths\PrecisionMaths\Number
     */
    public function sub($rightOperand)
    {
        return $this->subtract($rightOperand);
    }
    
    /**
     * Multiplies $rightOperand value by current value and retuns calculated
     * value as new instance of Number
     *
     * @param mixed $rightOperand
     * @return PrecisionMaths\Number
     */
    public function multiply($rightOperand)
    {
        return self::create(bcmul($this, $rightOperand, $this->scale));
    }
    
    /**
     * Alias for subtract
     *
     * @see self::multiply()
     * @param mixed $rightOperand
     * @return \PrecisionMaths\PrecisionMaths\Number
     */
    public function mul($rightOperand)
    {
        return $this->multiply($rightOperand);
    }
    
    /**
     * Divides current value by $rightOperand value and retuns calculated
     * value as new instance of Number
     *
     * @param mixed $rightOperand
     * @return PrecisionMaths\Number
     */
    public function divide($rightOperand)
    {
        return self::create(bcdiv($this, $rightOperand, $this->scale));
    }
    
    /**
     * Alias for divide
     *
     * @see self::divide()
     * @param mixed $rightOperand
     * @return \PrecisionMaths\PrecisionMaths\Number
     */
    public function div($rightOperand)
    {
        return $this->divide($rightOperand);
    }

    /**
     * Calculates and returns modulus
     * value as new instance of Number
     *
     * @param mixed $rightOperand
     * @return PrecisionMaths\Number
     */
    public function modulus($modulus)
    {
        return self::create(bcmod($this, $modulus, $this->scale));
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
     * @param mixed $rightOperand
     * @return PrecisionMaths\Number
     */
    public function power($rightOperand)
    {
        return self::create(bcpow($this, $rightOperand, $this->scale));
    }
    
    /**
     * Alias for power
     *
     * @see self::power()
     * @param mixed $power
     * @return \PrecisionMaths\PrecisionMaths\Number
     */
    public function pow($rightOperand)
    {
        return $this->modulus($rightOperand);
    }
    
    /**
     * Raise number by $rightOperand, and reduced by a $modulus
     * value and returns as new instance of Number
     *
     * @param mixed $rightOperand
     * @return PrecisionMaths\Number
     */
    public function powerModulus($rightOperand, $modulus)
    {
        return self::create(bcpowmod($this, $rightOperand, $modulus, $this->scale));
    }
    
    /**
     * Alias for powerModulus
     *
     * @see self::powerModulus()
     * @param mixed $rightOperand
     * @param mixed $modulus
     * @return \PrecisionMaths\PrecisionMaths\Number
     */
    public function powmod($rightOperand, $modulus)
    {
        return $this->powermodulus($rightOperand, $modulus);
    }
    
    /**
     * Returns the square root of the number as a new
     * instance of number
     *
     * @param mixed $rightOperand
     * @return PrecisionMaths\Number
     */
    public function sqaureroot()
    {
        return self::create(bcsqrt($this, $this->scale));
    }
    
    /**
     * Alias for squareroot
     *
     * @see self::squareroot()
     * @return \PrecisionMaths\PrecisionMaths\Number
     */
    public function sqrt()
    {
        return $this->sqaureroot();
    }
    
    /**
     * Compares this by $right operand
     * Returns 0 if the two operands are equal, 1 if the left_operand is larger than the right_operand, -1 otherwise.
     * 
     * @link http://php.net/manual/en/function.bccomp.php
     * @param mixed $rightOperand
     * @return PrecisionMaths\Number
     */
    public function compare($rightOperand)
    {
        return bccomp($this, $rightOperand, $this->scale);
    }
    
    /**
     * Returns true if this number is less than 
     * the value provided to $rightOperand Arg
     *
     * @param mixed $rightOperand
     * @return Boolean
     */
    public function lessThan($rightOperand)
    {
    	if (bccomp($this, $rightOperand, $this->scale) === -1) {
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
     * @return Boolean
     */
    public function lt($rightOperand)
    {
    	return $this->lessThan($rightOperand);
    }
    
    public function greaterThan($rightOperand)
    {
        if (bccomp($this, $rightOperand, $this->scale) === 1) {
            return true;
        } else {
        	return false;
        }
    }
    
    public function gt($rightOperand)
    {
        return $this->greaterThan($rightOperand);
    }
    
    public function floor()
    {
        $result = self::create(bcmul($this, '1', 0));
        
        if ($this->isNegative()) {
            $result = $result->sub('1', 0);
        }
        
        return self::create($result, 0);
    }
    
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
    
    public function round($precision, $type)
    {
        return self::create(round((int) $this, $precision, $type));
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
    	switch (preg_match('/^\-?\d+(\.\d+)?$/', (string) $value)) {
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
    public static function create($value)
    {
    	return new static($value);
    }
}