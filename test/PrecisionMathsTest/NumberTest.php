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
	
	public function tesIimpreciseRound()
	{
	    $number = new Number('2.43434');
	    $result = $number->impreciseRound(2);
	    $this->assertEquals('2.43', $result);
	    
	    $number = new Number('2.43634');
	    $result = $number->impreciseRound(2);
	    $this->assertEquals('2.44', $result);
	    
	    $number = new Number('2.43534');
	    $result = $number->impreciseRound(2);
	    $this->assertEquals('2.44', $result);
	     
	    $number = new Number('-2.43434');
	    $result = $number->impreciseRound(2);
	    $this->assertEquals('-2.43', $result);
	     
	    $number = new Number('-2.43634');
	    $result = $number->impreciseRound(2);
	    $this->assertEquals('-2.44', $result);
	     
	    $number = new Number('-2.43534');
	    $result = $number->impreciseRound(2);
	    $this->assertEquals('-2.44', $result);
	}
	
	public function testRound()
	{
	    $number = new Number('2.43434');
	    $result = $number->round(2);
	    $this->assertEquals('2.43', $result);
	    
	    $number = new Number('2.43534');
	    $result = $number->round(2);
	    $this->assertEquals('2.43', $result);
	    

	    $number = new Number('2.4353465465465');
	    $result = $number->round(12);
	    $this->assertEquals('2.435346546546', $result);
	}
	
	public function testPrecisionRoundWorksWithStringForPrecision()
	{
    	$number = new Number('2.4353465465465');
    	$result = $number->impreciseRound('1');
    	$this->assertEquals('2.4', $result);
	}
	
	public function testAddingPreciseNumbersTogether()
	{
	    $number = new Number('2.5');
	    $numberTwo = new Number('2.5');
	
	    $result = $number->add($numberTwo);
	    
	    $this->assertEquals('5.000000000000000000000', $result);
	}
	
	public function testGetValueAsInt()
	{
	    $number = new Number('2.5');
	    $this->assertEquals('integer', gettype($number->getValueAsInt()));
	    $this->assertEquals(2, $number->getValueAsInt());
	}
	
	public function testIsWholeNumber()
	{
	    $wholeNumber = new Number('2', 4);
        $this->assertTrue($wholeNumber->isWholeNumber());    
	    
        $wholeNumberWithDecimalPoint = new Number('2.000', 4);
        $this->assertTrue($wholeNumberWithDecimalPoint->isWholeNumber());
         
        $fractionalNumber = new Number('2.454', 4);
        $this->assertFalse($fractionalNumber->isWholeNumber());
         
	}
	
	public function testGetScale()
	{
	    $number = new Number('2.5', 20);
	    $this->assertEquals(20, $number->getScale());
	    
	    $number = new Number('2.5454564', 10);
	    $this->assertEquals(10, $number->getScale());
	}
	
	public function testGreaterThan()
	{
	    //gt
	    
	    $number = new Number('2.5', 20);
	    $this->assertTrue($number->gt('1.24234'));
	    
	    $number = new Number('2.5', 20);
	    $this->assertTrue($number->gt(1.24234));
	    
	    $number = new Number('2.5', 20);
	    $this->assertFalse($number->gt('2000'));
	    
	    $number = new Number('2.5', 20);
	    $this->assertFalse($number->gt(2000));
	    
	    $number = new Number('2.5', 20);
	    $this->assertTrue($number->gt('2.49999999999999999999999999999999999999999999'));
	    
	    $number = new Number('2.5', 20);
	    $this->assertFalse($number->gt('2.500000000000000000000000000000000000000000000000000000001'));
	    
	    // greaterThan
	    
	    $number = new Number('2.5', 20);
	    $this->assertTrue($number->greaterThan('1.24234'));
	     
	    $number = new Number('2.5', 20);
	    $this->assertTrue($number->greaterThan(1.24234));
	     
	    $number = new Number('2.5', 20);
	    $this->assertFalse($number->greaterThan('2000'));
	     
	    $number = new Number('2.5', 20);
	    $this->assertFalse($number->greaterThan(2000));
	     
	    $number = new Number('2.5', 20);
	    $this->assertTrue($number->greaterThan('2.49999999999999999999999999999999999999999999'));
	     
	    $number = new Number('2.5', 20);
	    $this->assertFalse($number->greaterThan('2.500000000000000000000000000000000000000000000000000000001'));
	}
	
	public function testLessThan()
	{
	    //lt
	     
	    $number = new Number('2.5', 20);
	    $this->assertFalse($number->lt('1.24234'));
	     
	    $number = new Number('2.5', 20);
	    $this->assertFalse($number->lt(1.24234));
	     
	    $number = new Number('2.5', 20);
	    $this->assertTrue($number->lt('2000'));
	     
	    $number = new Number('2.5', 20);
	    $this->assertTrue($number->lt(2000));
	     
	    $number = new Number('2.5', 20);
	    $this->assertFalse($number->lt('2.49999999999999999999999999999999999999999999'));
	     
	    $number = new Number('2.5', 20);
	    $this->assertTrue($number->lt('2.50000000000000000001'));
	     
        // Over the default precision
	    $number = new Number('2.5', 20);
	    $this->assertFalse($number->lt('2.500000000000000000000000000000000000000000000000000001'));
	    
	    // lessThan
	     
	    $number = new Number('2.5', 20);
	    $this->assertFalse($number->lessThan('1.24234'));
	
	    $number = new Number('2.5', 20);
	    $this->assertFalse($number->lessThan(1.24234));
	
	    $number = new Number('2.5', 20);
	    $this->assertTrue($number->lessThan('2000'));
	
	    $number = new Number('2.5', 20);
	    $this->assertTrue($number->lessThan(2000));
	
	    $number = new Number('2.5', 20);
	    $this->assertFalse($number->lessThan('2.49999999999999999999999999999999999999999999'));
	
	    $number = new Number('2.5', 20);
	    $this->assertTrue($number->lessThan('2.50000000000000000001'));
	    
	    // Over the default precision
	    $number = new Number('2.5', 20);
	    $this->assertFalse($number->lessThan('2.500000000000000000000000000000000000000000000000000001'));
	}
	
	public function testPower()
	{
	    $number = new Number('2', 20);
	    $this->assertEquals('4', $number->pow('2'));
	    $this->assertEquals('4', $number->power('2'));
	    
	    $number = new Number('-2', 20);
	    $this->assertEquals('4', $number->pow('2'));
	    $this->assertEquals('4', $number->power('2'));
	    
	    $number = new Number('2', 20);
	    $this->assertEquals('8', $number->pow('3'));
	    $this->assertEquals('8', $number->power('3'));
	     
	    $number = new Number('-2', 20);
	    $this->assertEquals('-8', $number->pow('3'));
	    $this->assertEquals('-8', $number->power('3'));

	    $number = new Number('2.5645654', 20);
	    $this->assertEquals('16.86713558477266018626', $number->pow('3'));
	    $this->assertEquals('16.86713558477266018626', $number->power('3'));
	    
	    $number = new Number('-2.5645654', 20);
	    $this->assertEquals('-16.86713558477266018626', $number->pow('3'));
	    $this->assertEquals('-16.86713558477266018626', $number->power('3'));
	}
}