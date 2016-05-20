<?php

namespace CTIMT\MyOrm\Exception\Adapter;

use CTIMT\MyOrm\Enum\ErrorMessages;
use CTIMT\MyOrm\Exception\ExceptionInterface;

/**
 * Description of InvalidFilterKey
 *
 * @author David
 */
class InvalidFilterKey extends LogicException implements ExceptionInterface {

    public function __construct($invalidKeys, $validKeys) {
        parent::__construct(sprintf(ErrorMessages::ADAPTER_FILTER_INVALID_KEYS, implode(',', $invalidKeys), implode(',', $validKeys)));
    }

}
