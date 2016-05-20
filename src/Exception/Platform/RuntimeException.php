<?php

namespace CTIMT\MyOrm\Exception\Platform;

use CTIMT\MyOrm\Exception\ExceptionInterface;
use RuntimeException as Runtime;

/**
 * Exception thrown if an error which can only be found on runtime occurs.
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class RuntimeException extends Runtime implements ExceptionInterface {
    
}
