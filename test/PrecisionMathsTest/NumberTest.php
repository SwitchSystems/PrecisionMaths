<?php
namespace PrecisionMathsTest;

use PrecisionMaths\Number;
class NumberTest extends \PHPUnit_Framework_TestCase
{
	public function testCanIntatiateNumber()
	{
	    $valueString = '1.111';
	    $valueFloat = 1.111;
	    $valueInt = 1;
	    
		$number = new Number($valueString);
		$this->assertEquals($valueString, $number);
		
		$number = new Number($valueInt);
		$this->assertEquals((string) $valueInt, $number);
		
		$number = new Number($valueFloat);
		$this->assertEquals((string) $valueFloat, $number);
	}
	
	public function testIntatiateNumberWithInvalidStringThrowsException()
	{
	    $this->setExpectedException('InvalidArgumentException');
	    
	    $value = 'IWishIWasANumber';
	    $number = new Number($value);
	    
	    $this->setExpectedException('InvalidArgumentException');
	    
	    $value = '1IWishIWasANumber';
	    $number = new Number($value);
	}
	
	public function testAdditionOperation()
	{
	    $valueString = '10.919191919';
	    $rightOperandString = '5.342342';
	    
	    $number = new Number($valueString);
	    $result = $number->addition($rightOperandString);
	    $this->assertEquals("16.26153391900000000000", $result);
	    
	    $result = $number->add($rightOperandString);
	    $this->assertEquals("16.26153391900000000000", $result);
	}

	public function testSubtractOperation()
	{
	    $valueString = '10.919191919';
	    $rightOperandString = '5.342342';
	
	    $number = new Number($valueString);
	    $result = $number->subtract($rightOperandString);
	    $this->assertEquals("5.576849919000000000", $result);
	
	    $result = $number->sub($rightOperandString);
	    $this->assertEquals("5.576849919000000000",  $result);
	}
	
	public function testMultiplyOperation()
	{
	    $valueString = '10.919191919';
	    $rightOperandString = '5.342342';
	
	    $number = new Number($valueString);
	    $result = $number->multiply($rightOperandString);
	    $this->assertEquals("58.334057594934298", $result);
	
	    $result = $number->mul($rightOperandString);
	    $this->assertEquals("58.334057594934298",  $result);
	    bcscale(20);
	    $innerval = bcdiv(20, 100);
	    $value = bcmul($innerval, 200);
	    var_dump(gettype($number));
	}
}