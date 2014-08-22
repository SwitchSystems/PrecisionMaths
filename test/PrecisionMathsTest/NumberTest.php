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
	
	public function testInstantiateNumberWithInvalidStringThrowsException()
	{
	    $this->setExpectedException('InvalidArgumentException');
	    
	    $value = 'IWishIWasANumber';
	    $number = new Number($value);
	    
	    $this->setExpectedException('InvalidArgumentException');
	    
	    $value = '1IWishIWasANumber';
	    $number = new Number($value);
	}
	
	public function testCanInstantiateNumberFromAnotherNumber()
	{
		$number = new Number('2.5');
		$numberTwo = new Number($number);
		
		$this->assertEquals($number, $numberTwo);
		$this->assertEquals((string) $number, (string) $numberTwo);
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

	public function testInvalidRightOperandAdditionOperation()
	{
	    $this->setExpectedException('InvalidArgumentException');
	    
	    $valueString = '10.919191919';
	    $rightOperandString = 'Number Two';
	     
	    $number = new Number($valueString);
	    
	    $result = $number->addition($rightOperandString);
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
	
	public function testInvalidRightOperandMultiplyOperation()
	{
	    $this->setExpectedException('InvalidArgumentException');
	     
	    $valueString = '10.919191919';
	    $rightOperandString = 'Number Two';
	
	    $number = new Number($valueString);
	     
	    $result = $number->multiply($rightOperandString);
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
	
	public function testRound()
	{
	    $number = new Number('2.43434');
	    $result = $number->round(2);
	    $this->assertEquals('2.43', $result);
	    
	    $number = new Number('2.43634');
	    $result = $number->round(2);
	    $this->assertEquals('2.44', $result);
	    
	    $number = new Number('2.43534');
	    $result = $number->round(2);
	    $this->assertEquals('2.44', $result);
	     
	    $number = new Number('-2.43434');
	    $result = $number->round(2);
	    $this->assertEquals('-2.43', $result);
	     
	    $number = new Number('-2.43634');
	    $result = $number->round(2);
	    $this->assertEquals('-2.44', $result);
	     
	    $number = new Number('-2.43534');
	    $result = $number->round(2);
	    $this->assertEquals('-2.44', $result);
	}
	
	public function testPrecisionRound()
	{
	    $number = new Number('2.43434');
	    $result = $number->precisionRound(2);
	    $this->assertEquals('2.43', $result);
	    
	    $number = new Number('2.43534');
	    $result = $number->precisionRound(2);
	    $this->assertEquals('2.43', $result);
	    

	    $number = new Number('2.4353465465465');
	    $result = $number->precisionRound(12);
	    $this->assertEquals('2.435346546546', $result);
	}
	
	public function testPrecisionRoundWorksWithStringForPrecision()
	{
    	$number = new Number('2.4353465465465');
    	$result = $number->precisionRound('1');
    	$this->assertEquals('2.4', $result);
	}
}