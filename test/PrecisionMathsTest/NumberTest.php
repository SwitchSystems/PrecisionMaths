<?php
/* Copyright (c) 2014, 2015 Switch Systems Ltd
 *
* This Source Code Form is subject to the terms of the Mozilla Public
* License, v. 2.0. If a copy of the MPL was not distributed with this
* file, You can obtain one at http://mozilla.org/MPL/2.0/. */

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
		$this->assertSame($valueString, (string) $number);
		
		$number = new Number($valueInt);
		$this->assertSame((string) $valueInt, (string) $number);
		
		$number = new Number($valueFloat);
		$this->assertSame((string) $valueFloat, (string) $number);
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
	    $this->assertSame("16.26153391900000000000", (string) $result);
	    
	    $result = $number->add($rightOperandString);
	    $this->assertSame("16.26153391900000000000", (string) $result);
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
	    $this->assertSame("5.57684991900000000000", (string) $result);
	
	    $result = $number->sub($rightOperandString);
	    $this->assertSame("5.57684991900000000000", (string) $result);
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
	    $this->assertSame("58.334057594934298", (string) $result);
	
	    $result = $number->mul($rightOperandString);
	    $this->assertSame("58.334057594934298",  (string) $result);
	}
	
	public function testDivideOperation()
	{
	    $valueString = '10.919191919';
	    $rightOperandString = '5.342342';
	
	    $number = new Number($valueString);
	    $result = $number->divide($rightOperandString);
	    $this->assertSame("2.04389608883145257267", (string) $result);
	
	    $result = $number->div($rightOperandString);
	    $this->assertSame("2.04389608883145257267",  (string) $result);
	}
	
	public function testFloorOperation()
	{
	    $number = new Number('2.4');
	    $result = $number->floor();
	    $this->assertSame("2", (string) $result);
	    
	    $number = new Number('-2.4');
	    $result = $number->floor();
	    $this->assertSame("-3", (string) $result);
	}
	
	public function testCeilOperation()
	{
	    $number = new Number('2.4');
	    $result = $number->ceil();
	    $this->assertSame("3", (string) $result);
	     
	    $number = new Number('-2.4');
	    $result = $number->ceil();
	    $this->assertSame("-2", (string) $result);
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
	    $this->assertSame('2.43', $result);
	    
	    $number = new Number('2.43634');
	    $result = $number->impreciseRound(2);
	    $this->assertSame('2.44', $result);
	    
	    $number = new Number('2.43534');
	    $result = $number->impreciseRound(2);
	    $this->assertSame('2.44', $result);
	     
	    $number = new Number('-2.43434');
	    $result = $number->impreciseRound(2);
	    $this->assertSame('-2.43', $result);
	     
	    $number = new Number('-2.43634');
	    $result = $number->impreciseRound(2);
	    $this->assertSame('-2.44', $result);
	     
	    $number = new Number('-2.43534');
	    $result = $number->impreciseRound(2);
	    $this->assertSame('-2.44', $result);
	}
	
	public function testRound()
	{
	    $number = new Number('2.43434');
	    $result = $number->round(2);
	    $this->assertSame('2.43',(string) $result);
	    
	    $number = new Number('2.43534');
	    $result = $number->round(2);
	    $this->assertSame('2.43', (string) $result);
	    

	    $number = new Number('2.4353465465465');
	    $result = $number->round(12);
	    $this->assertSame('2.435346546546', (string) $result);
	}
	
	public function testPrecisionRoundWorksWithStringForPrecision()
	{
    	$number = new Number('2.4353465465465');
    	$result = $number->impreciseRound('1');
    	$this->assertSame('2.4', (string) $result);
	}
	
	public function testAddingPreciseNumbersTogether()
	{
	    $number = new Number('2.5');
	    $numberTwo = new Number('2.5');
	
	    $result = $number->add($numberTwo);
	    
	    $this->assertSame('5.00000000000000000000', (string) $result);
	}
	
	public function testGetValueAsInt()
	{
	    $number = new Number('2.5');
	    $this->assertSame('integer', gettype($number->getValueAsInt()));
	    $this->assertSame(2, $number->getValueAsInt());
	}
	
	public function testGetValueAsFloat()
	{                         
	    $number = new Number('2.553454545345345');
	    $this->assertSame('double', gettype($number->getValueAsFloat()));
	    $this->assertSame(2.5534545453452999, $number->getValueAsFloat());
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
	    $this->assertSame(20, $number->getScale());
	    
	    $number = new Number('2.5454564', 10);
	    $this->assertSame(10, $number->getScale());
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
	    $this->assertSame('4', (string) $number->pow('2'));
	    $this->assertSame('4', (string) $number->power('2'));
	    
	    $number = new Number('-2', 20);
	    $this->assertSame('4', (string) $number->pow('2'));
	    $this->assertSame('4', (string) $number->power('2'));
	    
	    $number = new Number('2', 20);
	    $this->assertSame('8', (string) $number->pow('3'));
	    $this->assertSame('8', (string) $number->power('3'));
	     
	    $number = new Number('-2', 20);
	    $this->assertSame('-8', (string) $number->pow('3'));
	    $this->assertSame('-8', (string) $number->power('3'));

	    $number = new Number('2.5645654', 20);
	    $this->assertSame('16.86713558477266018626', (string) $number->pow('3'));
	    $this->assertSame('16.86713558477266018626', (string) $number->power('3'));
	    
	    $number = new Number('-2.5645654', 20);
	    $this->assertSame('-16.86713558477266018626', (string) $number->pow('3'));
	    $this->assertSame('-16.86713558477266018626',  (string) $number->power('3'));
	}
	
	public function testSquareroot()
	{
	    $number = new Number('34', 20);

        $this->assertSame('5.83095189484530047087', (string) $number->sqrt());
	    $this->assertSame('5.83095189484530047087', (string) $number->squareroot());
	}
	
	public function testMod()
	{
	    $number = new Number('34', 20);
	    
	    $this->assertSame('0', (string) $number->mod('2'));
	    $this->assertSame('0', (string) $number->modulus('2'));
	    
	    $numberTwo = new Number('35', 20);
	     
	    $this->assertSame('1', (string) $numberTwo->mod('2'));
	    $this->assertSame('1', (string) $numberTwo->modulus('2'));
	}
	
	public function testModPow()
	{
	    $number = new Number('21', 20);

	    $this->assertSame('1', (string) $number->powmod('1', '2', 0));
	    $this->assertSame('1', (string) $number->powerModulus('1', '2', 0));

	    $this->assertSame('9', (string) $number->powmod('1', '12', 0));
	    $this->assertSame('9', (string) $number->powerModulus('1', '12', 0));
	}
	
	public function testComp()
	{
	    $number = new Number('21', 20);
	    $this->assertSame('0', (string) $number->compare('21'));
	    $this->assertSame('0', (string) $number->comp('21'));
	    
	    $number = new Number('21.23432423', 20);
	    $this->assertSame('0', (string) $number->compare('21.23432423'));
	    $this->assertSame('0', (string) $number->comp('21.23432423'));
	    

	    $number = new Number('23.23432423', 20);
	    $this->assertSame('1', (string) $number->compare('21.23432423'));
	    $this->assertSame('1', (string) $number->comp('21.23432423'));
	    
	    $number = new Number('19.23432423', 20);
	    $this->assertSame('-1', (string) $number->compare('21.23432423'));
	    $this->assertSame('-1', (string) $number->comp('21.23432423'));
	}

	public function testConvertToFloat()
	{
		$number = new Number('21.342342342', 20);
		$this->assertSame(21.342342342, $number->convertToFloat());
	}

	public function testConvertToFloatWithRounding()
	{
		$number = new Number('21.342342342', 20);
		$number = $number->round(2);
		$this->assertSame(21.34, $number->convertToFloat());
	}

	public function testConvertToFloatTwentyDecimalPlaces()
	{
		$number = new Number('2.456258785437', 20);
		$this->assertSame(2.456258785437, $number->convertToFloat());
	}

	public function testNumberFormat()
	{
		$number = new Number('2.456258785437', 20);
		$this->assertSame(2.46, $number->numberFormat(2));

		$number = new Number('200000.456258785437', 20);
		$this->assertSame(2200000.46, $number->numberFormat(2));

		$number = new Number('2.454258785437', 20);
		$this->assertSame(2.46, $number->numberFormat(2));

		$number = new Number('2.44', 20);
		$this->assertSame(2.46, $number->numberFormat(2));
	}
}