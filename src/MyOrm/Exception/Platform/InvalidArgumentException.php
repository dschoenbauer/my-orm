<?php

namespace CTIMT\MyOrm\Exception\Platform;

use CTIMT\MyOrm\Exception\ExceptionInterface;
use InvalidArgumentException as InvalidArgument;

/**
 * Exception thrown if an argument is not of the expected type.
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class InvalidArgumentException extends InvalidArgument implements ExceptionInterface {
    
}
