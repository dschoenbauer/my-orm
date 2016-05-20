<?php

namespace CTIMT\MyOrm\Exception\Http;

use CTIMT\MyOrm\Exception\Platform\RuntimeException;

/**
 * Error code response for missing or invalid authentication token.
 *
 * @author David
 */
class Unauthorized extends RuntimeException implements HttpExceptionInterface {

    public function __construct($message = "") {
        parent::__construct($message, 401);
    }

}
