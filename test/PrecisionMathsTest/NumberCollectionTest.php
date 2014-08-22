<?php
namespace PrecisionMathsTest;

use PrecisionMaths\Number;
use PrecisionMaths\NumberCollection;

class NumberTest extends \PHPUnit_Framework_TestCase
{
	public function testSum()
	{
	    $array = [1, 2, 4, 5, 6];
		$numberCollection = new NumberCollection($array);
		
		$result = $numberCollection->sum();
		$this->assertEquals('18.00000000000000000000', $result);
	}
	
	public function testSumMixedArray()
	{
	    $array = [1, 6, 2, 4.25, '5'];
	    $numberCollection = new NumberCollection($array);
	
	    $result = $numberCollection->sum();
	    $this->assertEquals('18.25000000000000000000', $result);
	}
	
	/*public function testSumMixedArrayInvalid()
	{
	    $array = [1, 6, 2, 4.25, 'NumberFive'];
	    $numberCollection = new NumberCollection($array);
	
	    $result = $numberCollection->sum();
	    $this->assertEquals('18.25000000000000000000', $result);
	}*/
	
	public function testMean()
	{
	    $array = [1, 6, 2, 4, '5'];
	    $numberCollection = new NumberCollection($array, 2);
	    
	    $result = $numberCollection->mean();
	    $this->assertEquals('3.6', $result);
	}
	
	public function testRangeSorted()
	{
	    $array = [1, 2, 5, 6, 7];
	    $numberCollection = new NumberCollection($array, 2);
	     
	    $result = $numberCollection->range();
	    $this->assertEquals('6.00', $result);
	}
	
	public function testRangeUnSorted()
	{
	    $array = [7, 1, 2, 5, 6];
	    $numberCollection = new NumberCollection($array, 2);
	
	    $result = $numberCollection->range();
	    $this->assertEquals('6.00', $result);
	}
	
	public function testRangeUnSortedMixed()
	{
	    $array = [7, '1', 2, 5.00, '6'];
	    $numberCollection = new NumberCollection($array, 2);
	
	    $result = $numberCollection->range();
	    $this->assertEquals('6.00', $result);
	}
}