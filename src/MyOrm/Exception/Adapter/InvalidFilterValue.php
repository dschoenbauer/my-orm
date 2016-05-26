<?php namespace CTIMT\MyOrm\Exception\Adapter;

use CTIMT\MyOrm\Enum\ErrorMessages;
use CTIMT\MyOrm\Exception\ExceptionInterface;
use CTIMT\MyOrm\Exception\Http\UnprocessableEntity;

/**
 * Description of InvalidFilterValue
 *
 * @author David
 */
class InvalidFilterValue extends UnprocessableEntity implements ExceptionInterface
{

    public function __construct(array $invalidValues, $field,array $validValues)
    {
        parent::__construct(sprintf(ErrorMessages::ADAPTER_FILTER_INVALID_VALUES, implode(',', $invalidValues), $field, implode(',', $validValues)));
    }
}
