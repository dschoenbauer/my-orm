<?php namespace CTIMT\MyOrm\Exception\Platform;

use CTIMT\MyOrm\Exception\ExceptionInterface;
use LogicException as Logic;

/**
 * Exception that represents error in the program logic.
 * This kind of exception should lead directly to a fix in your code.
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class LogicException extends Logic implements ExceptionInterface
{
    
}
