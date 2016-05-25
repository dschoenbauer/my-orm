<?php namespace CTIMT\MyOrm\Exception\Http;

use CTIMT\MyOrm\Exception\Platform\InvalidArgumentException;

/**
 * The request could not be understood by the server due to malformed syntax. The client SHOULD NOT repeat the request without modifications.
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class BadRequest extends InvalidArgumentException implements HttpExceptionInterface
{

    public function __construct($message = "")
    {
        parent::__construct($message, 400);
    }
}
