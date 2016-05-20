<?php

namespace CTIMT\MyOrm\Exception\Http;

use CTIMT\MyOrm\Exception\Platform\RuntimeException;

/**
 * Intended to be used when resource access is denied for legal reasons, e.g. censorship or government-mandated blocked access. A reference to the 1953 dystopian novel Fahrenheit 451, where books are outlawed, and the autoignition temperature of paper, 451°F.
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class UnavailableForLegalReasons extends RuntimeException implements HttpExceptionInterface {

    public function __construct($message = "") {
        parent::__construct($message, 451);
    }

}
