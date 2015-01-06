<?php
/* Copyright (c) 2014, 2015 Switch Systems Ltd
 *
* This Source Code Form is subject to the terms of the Mozilla Public
* License, v. 2.0. If a copy of the MPL was not distributed with this
* file, You can obtain one at http://mozilla.org/MPL/2.0/. */

namespace PrecisionMathsTest;

use PrecisionMaths\Number;
use PrecisionMaths\NumberCollection;

class NumberCollectionTest extends \PHPUnit_Framework_TestCase
{
	public function testSum()
	{
	    $array = [1, 2, 4, 5, 6];
		$numberCollection = new NumberCollection($array);
		
		$result = $numberCollection->sum();
		$this->assertSame('18.00000000000000000000', (string) $result);
	}
	
	public function testSumMixedArray()
	{
	    $array = [1, 6, 2, 4.25, '5'];
	    $numberCollection = new NumberCollection($array);
	
	    $result = $numberCollection->sum();
	    $this->assertSame('18.25000000000000000000', (string) $result);
	}
	
	public function testSumMixedArrayInvalid()
	{
	    $this->setExpectedException('RuntimeException');
	    
	    $array = [1, 6, 2, 4.25, 'NumberFive'];
	    $numberCollection = new NumberCollection($array);
	}
	
	public function testMean()
	{
	    $array = [1, 6, 2, 4, '5'];
	    $numberCollection = new NumberCollection($array, 2);
	    
	    $result = $numberCollection->mean();
	    $this->assertSame('3.60', (string) $result);
	}
	
	public function testRangeSorted()
	{
	    $array = [1, 2, 5, 6, 7];
	    $numberCollection = new NumberCollection($array, 2);
	     
	    $result = $numberCollection->range();
	    $this->assertSame('6.00', (string) $result);
	}
	
	public function testRangeUnSorted()
	{
	    $array = [7, 1, 2, 5, 6];
	    $numberCollection = new NumberCollection($array, 2);
	
	    $result = $numberCollection->range();
	    $this->assertSame('6.00', (string) $result);
	}
	
	public function testRangeUnSortedMixed()
	{
	    $array = [7, '1', 2, 5.00, '6'];
	    $numberCollection = new NumberCollection($array, 2);
	
	    $result = $numberCollection->range();
	    $this->assertSame('6.00', (string) $result);
	}
	
	public function testLowerQuartile()
	{
	    $array = [7, '1', 2, 5.00, '6'];
	    $numberCollection = new NumberCollection($array);
	    
	    $result = $numberCollection->lowerQuartile();
	    $this->assertSame('1.50000000000000000000', (string) $result);
	}
	
	public function testUpperQuartile()
	{
	    $array = [7, '1', 2, 5.00, '6'];
	    $numberCollection = new NumberCollection($array);
	     
	    $result = $numberCollection->upperQuartile();
	    $this->assertSame('6.50000000000000000000', (string) $result);
	}

	public function testVariance()
	{
	    $array = [7, '1', 2, 5.00, '6'];
	    $numberCollection = new NumberCollection($array);
	    
        $this->assertSame("6.70000000000000000000", (string) $numberCollection->variance());
        $this->assertSame("5.36000000000000000000", (string) $numberCollection->populationVariance());
	}
	
	public function testStandardDeviation()
	{
	    $array = [7, '1', 2, 5.00, '6'];
	    $numberCollection = new NumberCollection($array);
	     
	    $this->assertSame("2.58843582110895691413", (string) $numberCollection->standardDeviation());
	    $this->assertSame("2.31516738055804509471", (string) $numberCollection->populationStandardDeviation());
	}
	
	public function testInterquartileRange()
	{
	    $array = [7, '1', 2, 5.00, '6'];
	    $numberCollection = new NumberCollection($array);
	     
	    $result = $numberCollection->interquartileRange();
	    $this->assertSame('5.00000000000000000000', (string) $result);
	}
	
	public function testMedian()
	{
	    $array = [1, 2, 4, 5, 6, 7, 9, 22, 101];
	    $numberCollection = new NumberCollection($array);
	    
	    $result = $numberCollection->median();
	    $this->assertSame('6', (string) $result);
	    
	    $array = [1, 2, 4, 5, 6, 7, 9, 22];
	    $numberCollection = new NumberCollection($array);
	     
	    $result = $numberCollection->median();
	    $this->assertSame('5.50000000000000000000', (string) $result);
	}
	
	public function testAppend()
	{
	    $array = [1, 2, 4, 5, 6, 22, 101];
	    $numberCollection = new NumberCollection($array);

	    $numberCollection->append(1.5);
	    $this->assertSame(['1', '1.5','2', '4', '5', '6', '22', '101'], $numberCollection->getSortedArrayCopy());

	    $numberCollection->append(1.75);
	    $this->assertSame(['1', '1.5', '1.75','2', '4', '5', '6', '22', '101'], $numberCollection->getSortedArrayCopy());
	    
	    $numberCollection->append(1.25);
	    $this->assertSame(['1', '1.25', '1.5', '1.75', '2', '4', '5', '6', '22', '101'], $numberCollection->getSortedArrayCopy());
	}
	
	public function testGetSortedArrayCopy()
	{
	    
	    $array = [1, 6, 2, 22, 4.25, '5'];
	    $numberCollection = new NumberCollection($array);
	    
	    $this->assertSame(['1', '2', '4.25', '5', '6', '22'], $numberCollection->getSortedArrayCopy());
	}
}