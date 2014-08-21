<?php
namespace PrecisionMaths;

class BasicOperations
{
    /**
     * Scale to use for BC MATH Operations
     * 
     * @var integer
     */
    protected $scale;
    
    public function __construct($scale)
    {
    	$this->scale = $scale;
    }
    
    public function addition($left, $right)
    {
        bcadd($left, $right, $this->scale);
    }
}