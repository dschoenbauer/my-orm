<?php namespace CTIMT\MyOrm\Exception\Platform;

use CTIMT\MyOrm\Exception\ExceptionInterface;
use DomainException as Domain;

/**
 * Exception thrown if a value does not adhere to a defined valid data domain.
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class DomainException extends Domain implements ExceptionInterface
{
    
}
