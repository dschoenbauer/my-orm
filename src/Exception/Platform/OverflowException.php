<?php

namespace CTIMT\MyOrm\Exception\Platform;

use CTIMT\MyOrm\Exception\ExceptionInterface;
use OverflowException as Overflow;

/**
 * Exception thrown when adding an element to a full container.
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class OverflowException extends Overflow implements ExceptionInterface {
    
}
