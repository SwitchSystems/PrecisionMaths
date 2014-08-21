<?php
namespace PrecisionMaths;

trait InitialiseNumberTrait
{
    /**
     * Sets the value to an instance of number if valid
     *
     * @param mixed $value
     * @throws RuntimeException
     */
    protected function initialiseNumber($value)
    {
        if (in_array(gettype($value), static::$validTypesList)) {
            return new Number($value);
        } elseif ($value instanceof Number) {
            return $value;
        } else {
            throw new RuntimeException(sprintf('$value provided to Tax Object is not valid'));
        }
    }
}