<?php namespace CTIMT\MyOrm\Exception\Visitor\DataType;

use CTIMT\MyOrm\Enum\ErrorMessages;

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
