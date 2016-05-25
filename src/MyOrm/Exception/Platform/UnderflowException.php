<?php namespace CTIMT\MyOrm\Exception\Platform;

use CTIMT\MyOrm\Exception\ExceptionInterface;
use UnderflowException as Underflow;

/**
 * Exception thrown when performing an invalid operation on an empty container, 
 * such as removing an element.
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class UnderflowException extends Underflow implements ExceptionInterface
{
    
}
