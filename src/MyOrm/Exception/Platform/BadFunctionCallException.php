<?php namespace CTIMT\MyOrm\Exception\Platform;

use BadFunctionCallException as BadFunctionCall;
use CTIMT\MyOrm\Exception\ExceptionInterface;

/**
 * Exception thrown if a callback refers to an undefined function or if some arguments are missing.
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class BadFunctionCallException extends BadFunctionCall implements ExceptionInterface
{
    
}
