<?php
namespace PrecisionMathsTest;

use PrecisionMaths\Utility\TaxUtility;
class TaxTest extends \PHPUnit_Framework_TestCase
{
    public function testCalculateTaxAmountOnGross()
    {
    	$util = new TaxUtility('20');
    	
    	$tax = $util->calculateTaxAmountOnGross('150');
    	$this->assertEquals('30.00000000000000000000', $tax);
    }
    
    /*public function	testCalculateTax()
    {
        $util = new TaxUtility('20.00', 2);
        
        // VAT 
        // net should be 125
        $net = $util->calculateNetFromGross('150');
        $this->assertEquals('125', $net);
        
        $gross = $util->calculateGrossFromNet($net);
        $this->assertEquals('150', $gross);
        
        $taxFromNet = $util->calculateTaxAmountFromNet($net);
        $this->assertEquals('25', $taxFromNet);
        
        // Income Tax
        // net should be 120
        $net = $util->calculateNetFromGross('150');
        $this->assertEquals('120', $net);
        
        $gross = $util->calculateGrossFromNet($net);
        $this->assertEquals('150', $gross);
        
        $taxFromNet = $util->calculateTaxAmountFromNet($net);
        $this->assertEquals('25', $taxFromNet);
    }*/
}