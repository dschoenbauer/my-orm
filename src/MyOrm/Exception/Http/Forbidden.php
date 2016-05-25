<?php namespace CTIMT\MyOrm\Exception\Http;

use CTIMT\MyOrm\Exception\Platform\RuntimeException;

/**
 * The server understood the request, but is refusing to fulfill it. Authorization will not help and the request SHOULD NOT be repeated. If the request method was not HEAD and the server wishes to make public why the request has not been fulfilled, it SHOULD describe the reason for the refusal in the entity. If the server does not wish to make this information available to the client, the status code 404 (Not Found) can be used instead.
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Forbidden extends RuntimeException implements HttpExceptionInterface
{

    public function __construct($message = "")
    {
        parent::__construct($message, 403);
    }
}
