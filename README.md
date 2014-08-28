# Precision Maths

This module provides various classes for performing precision mathematics using BC MATH Internally 

See <http://php.net/manual/en/book.bc.php> for more information on BC Math Extension

## Number Class

The precision number class provides all the basic math operations provides by the BC Math extension

Numbers are immutable and will always return a new object with the value of the operation.

__Example 1:__

`
    <?php
    
    $number = new Number('20'); // Instatiates Number object with a value of 20
    $result = $number->add('20'); // returns a new instance of Number with a value of 40
    echo $result; // prints '40' 
`

## Number Collection Class

## Tax Utility

## Finance Utility

## Decimal DateTime Utility