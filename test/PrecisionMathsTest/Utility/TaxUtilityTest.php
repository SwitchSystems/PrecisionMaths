<?php
/* Copyright (c) 2014, 2015 Switch Systems Ltd
 *
* This Source Code Form is subject to the terms of the Mozilla Public
* License, v. 2.0. If a copy of the MPL was not distributed with this
* file, You can obtain one at http://mozilla.org/MPL/2.0/. */

namespace PrecisionMathsTest;

use PrecisionMaths\Utility\TaxUtility;
class TaxUtilityTest extends \PHPUnit_Framework_TestCase
{
    public function testFetchValueOfTaxToBeAdded()
    {
        $util = new TaxUtility('20');
        
        $result = $util->fetchValueOfTaxToBeAdded('166');
        $this->assertSame("33.20000000000000000000", (string) $result);

        $result = $util->fetchValueOfTaxToBeAdded('166.23');
        $this->assertSame("33.24600000000000000000", (string) $result);
        
        
        $utilTwo = new TaxUtility('17.5');
        
        $result = $utilTwo->fetchValueOfTaxToBeAdded('166');
        $this->assertSame("29.05000000000000000000", (string) $result);
        
        $result = $utilTwo->fetchValueOfTaxToBeAdded('166.23');
        $this->assertSame("29.09025000000000000000", (string) $result);
    }
    
    public function testFetchValueOfAddedTax()
    {
        $util = new TaxUtility('20');
        
        $result = $util->fetchValueOfAddedTax('166');
        $this->assertSame("27.66666666666666666700", (string) $result);
        
        $result = $util->fetchValueOfAddedTax('166.23');
        $this->assertSame("27.70500000000000000000", (string) $result);
        
        
        $utilTwo = new TaxUtility('17.5');
        
        $result = $utilTwo->fetchValueOfAddedTax('166');
        $this->assertSame("24.72340425531914893700", (string) $result);
        
        $result = $utilTwo->fetchValueOfAddedTax('166.23');
        $this->assertSame("24.75765957446808510700", (string) $result);
    }
    
    public function testAddTaxTo()
    {
        $util = new TaxUtility('20');
        
        $result = $util->addTaxTo('166');
        $this->assertSame("199.20000000000000000000", (string) $result);
        

        $result = $util->addTaxTo('166.545454');
        $this->assertSame("199.85454480000000000000", (string) $result);
    }
    
    public function testRemoveTaxFrom()
    {
        $util = new TaxUtility('20');
    
        $result = $util->removeTaxFrom('166');
        $this->assertSame("138.33333333333333333300", (string) $result);
    
    
        $result = $util->removeTaxFrom('166.545454');
        $this->assertSame("138.78787833333333333300", (string) $result);
    }
}