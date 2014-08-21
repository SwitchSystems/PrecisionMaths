<?php
namespace PrecisionMaths;

use InvalidArgumentException;
use RuntimeException;

class Number
{
    use PrecisionMaths\InitialiseNumberTrait;
    
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
        $stringValue = (string) $value;
        
        if (! $this->isValid($stringValue)) {
            throw new InvalidArgumentException(sprintf('The value %s provided is not valid', $stringValue));
        }
        
        if ($scale !== null) { 
            $this->scale = (int) $scale;
        } else {
            $this->scale = self::DEFAULT_SCALE;	
        }
        
        $this->value = $stringValue;
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
        return $this->initialiseNumber(bcadd($this, $rightOperand, $this->scale));
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
        return $this->initialiseNumber(bcsub($this, $rightOperand, $this->scale));
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
        return $this->initialiseNumber(bcmul($this, $rightOperand, $this->scale));
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
        return $this->initialiseNumber(bcdiv($this, $rightOperand, $this->scale));
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
        return $this->initialiseNumber(bcmod($this, $modulus, $this->scale));
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
    
    public function power($rightOperand)
    {
        return $this->initialiseNumber(bcpow($this, $rightOperand, $this->scale));
    }
    
    public function pow($rightOperand)
    {
        return $this->modulus($rightOperand);
    }
    
    public function powerModulus($rightOperand, $modulus)
    {
        return $this->initialiseNumber(bcpowmod($this, $rightOperand, $modulus, $this->scale));
    }
    
    public function powmod($rightOperand, $modulus)
    {
        return $this->powermodulus($rightOperand, $modulus);
    }
    
    public function sqaureroot()
    {
        return $this->initialiseNumber(bcsqrt($this, $this->scale));
    }
    
    public function sqrt()
    {
        return $this->sqaureroot();
    }
    
    public function compare($rightOperand)
    {
        return bccomp($this, $rightOperand, $this->scale);
    }
    
    public function lessThan($rightOperand)
    {
    	if (bccomp($this, $rightOperand, $this->scale) === -1) {
    		return true;
    	} else {
        	return false;
        }
    }
    
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
        $result = $this->mul('1', 0);
        
        if (isNegative($this)) {
            $result = $result->sub('1', 0);
        }
        
        return $this->initialiseNumber($result, 0);
    }
    
    public function ceil()
    {
        $floor = $this->floor();

        return $this->initialiseNumber($floor->add('1', 0));
    }
    
    public function round($precision, $type)
    {
        return $this->initialiseNumber(round((int) $this, $precision, $type));
    }
    
    public function isNegative()
    {
    	if (substr($this, 0) === '-') {
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
    public function isValid($value)
    {
    	switch (preg_match('/^\-?\d+(\.\d+)?$/', $value)) {
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
}