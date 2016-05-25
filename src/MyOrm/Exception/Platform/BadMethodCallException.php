<?php namespace CTIMT\MyOrm\Exception\Platform;

use BadMethodCallException as BadMethodCall;
use CTIMT\MyOrm\Exception\ExceptionInterface;

/**
 * Exception thrown if a callback refers to an undefined method or if some arguments are missing.
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class BadMethodCallException extends BadMethodCall implements ExceptionInterface
{
    
}
