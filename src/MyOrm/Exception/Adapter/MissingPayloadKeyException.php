<?php namespace CTIMT\MyOrm\Exception\Adapter;

use CTIMT\MyOrm\Enum\ErrorMessages;
use CTIMT\MyOrm\Exception\ExceptionInterface;
use CTIMT\MyOrm\Exception\Platform\LogicException;

/**
 * Description of InvalidFilterKey
 *
 * @author David
 */
class MissingPayloadKeyException extends LogicException implements ExceptionInterface
{

    public function __construct($invalidKeys, $validKeys)
    {
        parent::__construct(sprintf(ErrorMessages::ADAPTER_MISSING_KEYS, implode(',', $invalidKeys), implode(',', $validKeys)));
    }
}
