<?php

namespace CTIMT\MyOrm\Exception\Platform;

use CTIMT\MyOrm\Exception\ExceptionInterface;
use OutOfRangeException as OutOfRange;

/**
 * Exception thrown when an illegal index was requested. This represents errors that should be detected at compile time.
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class OutOfRangeException extends OutOfRange implements ExceptionInterface {
    
}
