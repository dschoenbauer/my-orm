<?php

namespace CTIMT\MyOrm\Exception\Http;

use CTIMT\MyOrm\Exception\Platform\RuntimeException;

/**
 * Reliable, interoperable negotiation of Upgrade features requires an unambiguous failure signal. The 426 Upgrade Required status code allows a server to definitively state the precise protocol extensions a given resource must be served with.
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class UpgradeRequired extends RuntimeException implements HttpExceptionInterface {

    public function __construct($message = "") {
        parent::__construct($message, 426);
    }

}
