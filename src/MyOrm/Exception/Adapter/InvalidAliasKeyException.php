<?php namespace CTIMT\MyOrm\Exception\Adapter;

use CTIMT\MyOrm\Enum\ErrorMessages;
use CTIMT\MyOrm\Exception\ExceptionInterface;
use CTIMT\MyOrm\Exception\Http\BadRequest;

/**
 * Description of InvalidFilterKey
 *
 * @author David
 */
class InvalidAliasKeyException extends BadRequest implements ExceptionInterface
{

    public function __construct($invalidKeys, $validKeys)
    {
        parent::__construct(sprintf(ErrorMessages::ADAPTER_ALIAS_INVALID_KEYS, implode(',', $invalidKeys), implode(',', $validKeys)));
    }
}
