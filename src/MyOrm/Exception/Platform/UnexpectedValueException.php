<?php namespace CTIMT\MyOrm\Exception\Platform;

use CTIMT\MyOrm\Exception\ExceptionInterface;
use UnexpectedValueException as UnexpectedValue;

/**
 * Exception thrown if a value does not match with a set of values. 
 * Typically this happens when a function calls another function and expects the 
 * return value to be of a certain type or value not including arithmetic or 
 * buffer related errors.
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class UnexpectedValueException extends UnexpectedValue implements ExceptionInterface
{
    
}
