<?php

namespace CTIMT\MyOrm\Exception\Adapter;

use CTIMT\MyOrm\Enum\ErrorMessages;
use CTIMT\MyOrm\Exception\ExceptionInterface;
use CTIMT\MyOrm\Exception\Platform\LogicException;

/**
 * Description of InvalidFilterValue
 *
 * @author David
 */
class InvalidFilterValue extends LogicException implements ExceptionInterface {

    public function __construct($invalidValue, $field, $validValues) {
        parent::__construct(sprintf(ErrorMessages::ADAPTER_FILTER_INVALID_VALUES, implode(',', $invalidValue), $field, implode(',', $validValues)));
    }

}
