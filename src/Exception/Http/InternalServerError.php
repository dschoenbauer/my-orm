<?php

namespace CTIMT\MyOrm\Exception\Http;

use CTIMT\MyOrm\Exception\Platform\LogicException;

/**
 * The server encountered an unexpected condition which prevented it from fulfilling the request.
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class InternalServerError extends LogicException implements HttpExceptionInterface {

    public function __construct($message = "") {
        parent::__construct($message, 500);
    }

}
