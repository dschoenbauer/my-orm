<?php namespace CTIMT\MyOrm\Exception\Platform;

use CTIMT\MyOrm\Exception\ExceptionInterface;
use RangeException as Range;

/**
 * Exception thrown to indicate range errors during program execution. 
 * Normally this means there was an arithmetic error other than under/overflow. 
 * This is the runtime version of DomainException.
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class RangeException extends Range implements ExceptionInterface
{
    
}
