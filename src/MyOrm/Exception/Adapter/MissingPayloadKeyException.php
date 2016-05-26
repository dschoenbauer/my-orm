<?php namespace CTIMT\MyOrm\Exception\Adapter;

use CTIMT\MyOrm\Enum\ErrorMessages;
use CTIMT\MyOrm\Exception\Http\UnprocessableEntity;

/**
 * Description of InvalidFilterKey
 *
 * @author David
 */
class MissingPayloadKeyException extends UnprocessableEntity
{

    public function __construct(array $invalidKeys,array $validKeys)
    {
        parent::__construct(sprintf(ErrorMessages::ADAPTER_MISSING_KEYS, implode(',', $invalidKeys), implode(',', $validKeys)));
    }
}
