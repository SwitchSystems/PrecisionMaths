# Precision Maths

This module provides various classes for performing precision mathematics using BC MATH internally 

See <http://php.net/manual/en/book.bc.php> for more information on BC Math Extension

## Licence

This library is copyright 2014, 2015 Switch Systems Ltd and is licenced under the [Mozilla Public License 2.0](https://www.mozilla.org/MPL/2.0/).

## Number Class

The precision number class provides all the basic math operations provides by the BC Math extension

Numbers are immutable and will always return a new object with the value of the operation.

__Example:__

    $number = new Number('20'); // Instatiates Number object with a value of 20
    $result = $number->add('20'); // returns a new instance of Number with a value of 40
    echo $result; // prints '40' 

## Number Collection Class

The number collection can be instatiated with an array as the first argument. It has various methods for performing basic math operations on the set

* Mean
* Median
* Standard Deviation
* Range

__Example:__

    $numberCollection = new NumberCollection(['1', '2', '3']);
    $mean = $numberCollection->mean(); // returns a new instance of number set to the value of the mean of the set
    echo $mean; // prints '2'

## Tax Utility

This utility class can be instatiated to perform basic tax operations. It takes tax rate as the first argument of the constructor

### Methods: 

#### fetchValueOfTaxToBeAdded

Returns the value of tax that would be added:

    $vatUtil = new TaxUtility('20');
    $vat = $vatUtil->fetchValueOfTaxToBeAdded('125'); // Returns instance of number set to '25'
    echo $vat // prints '25'
    
#### fetchValueOfAddedTax

Returns the value of tax that would be added:

    $vatUtil = new TaxUtility('20');
    $vat = $vatUtil->fetchValueOfAddedTax('150'); // Returns instance of number set to '25'
    echo $vat // prints '25'
    
#### addTaxTo

Returns the value of tax that would be added:

    $vatUtil = new TaxUtility('20');
    $priceWithVat = $vatUtil->addTaxTo('125'); // Returns instance of number set to '150'
    echo $priceWithVat // prints '150'
    
#### removeTaxFrom

Returns the value of tax that would be added:

    $vatUtil = new TaxUtility('20');
    $priceWithVatRemoved = $vatUtil->removeTaxFrom('150'); // Returns instance of number set to '125'
    echo $priceWithVatRemoved // prints '125'
    
## Finance Utility

Currently only provides one method:

### calculatePayForPeriod

    $financeUtil = new FinanceUtility();
    $pay = $financeUtil->calculatePayForPeriod($startDateTimeObject, $endDateTimeObject, '6.50', '30');
    
## Decimal DateTime Utility

This class has a variety of methods for calculating time in a specified unit for a date range and various convertion methods

