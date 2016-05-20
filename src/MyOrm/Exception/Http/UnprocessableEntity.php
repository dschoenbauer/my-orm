<?php

namespace CTIMT\MyOrm\Exception\Http;

use CTIMT\MyOrm\Exception\Platform\InvalidArgumentException;

/**
 * The request was well-formed but was unable to be followed due to semantic errors.
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class UnprocessableEntity extends InvalidArgumentException implements HttpExceptionInterface {

    public function __construct($message = "") {
        parent::__construct($message, 422);
    }

}
