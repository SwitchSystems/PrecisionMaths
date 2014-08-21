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
	}
	
	public function testDivideOperation()
	{
	    $valueString = '10.919191919';
	    $rightOperandString = '5.342342';
	
	    $number = new Number($valueString);
	    $result = $number->divide($rightOperandString);
	    $this->assertEquals("2.04389608883145257267", $result);
	
	    $result = $number->div($rightOperandString);
	    $this->assertEquals("2.04389608883145257267",  $result);
	}
	
	public function testFloorOperation()
	{
	    $number = new Number('2.4');
	    $result = $number->floor();
	    $this->assertEquals("2", $result);
	    
	    $number = new Number('-2.4');
	    $result = $number->floor();
	    $this->assertEquals("-3", $result);
	}
	
	public function testCeilOperation()
	{
	    $number = new Number('2.4');
	    $result = $number->ceil();
	    $this->assertEquals("3", $result);
	     
	    $number = new Number('-2.4');
	    $result = $number->ceil();
	    $this->assertEquals("-2", $result);
	}
	
	public function testIsNegative()
	{
	    $negativeNumber = new Number('-2.4');
	    $positiveNumber = new Number('2.4');
	    
	    $this->assertTrue($negativeNumber->isNegative());
	    $this->assertFalse($positiveNumber->isNegative());
	}
}