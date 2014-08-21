<?php
namespace PrecisionMaths;

use InvalidArgumentException;
use RuntimeException;

class Number
{
    /**
     * @var string
     */
    protected $value;

    /**
     * Number constructor
     *
     * @param string $value
     */
    public function __construct($value = null)
    {
        if (! $this->isValid($value)) {
            throw new InvalidArgumentException(sprintf('The value %s provided is not valid', $value));
        }
        
        $this->value($value);
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