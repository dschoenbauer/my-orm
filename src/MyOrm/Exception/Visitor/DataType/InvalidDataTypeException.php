<?php namespace CTIMT\MyOrm\Exception\Visitor\DataType;

use CTIMT\MyOrm\Enum\ErrorMessages;
use CTIMT\MyOrm\Exception\Http\UnprocessableEntity;

/**
 * Description of InvalidDataTypeException
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class InvalidDataTypeException extends UnprocessableEntity
{

    public function __construct($field, $expectedDataType)
    {
        parent::__construct(ErrorMessages::invalidDataType($field, $expectedDataType));
    }
}
