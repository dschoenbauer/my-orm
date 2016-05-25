<?php namespace CTIMT\MyOrm\Enum;

/**
 * Description of ErrorMessages
 *
 * @author David
 */
class ErrorMessages
{

    const DATA_PROVIDER_MISSING_PARAMETER = 'You need to provide field: %s';
    const DATA_PROVIDER_MISSING_PARAMETERS = 'You need to provide one of the following fields: %s';
    const ADAPTER_ORDER_INVALID_KEYS = 'Order field:%s is invalid. Valid fields are: %s';
    const ADAPTER_ALIAS_INVALID_KEYS = 'Alias Key(s):%s are invalid. Valid keys are: %s';
    const ADAPTER_FILTER_INVALID_KEYS = 'Filter Key(s):%s are invalid. Valid keys are: %s';
    const ADAPTER_FILTER_INVALID_VALUES = 'Value %s is not a valid value for %s. Valid values are %s';
    const NO_VALID_FIELDS = "No valid fields are found";
    const QUERY_INSERT_EXCEPTION = "";
    const QUERY_UPDATE_EXCEPTION = "";
    const QUERY_DELETE_EXCEPTION = "";
    const INVALID_FILTER = 'Filter key: %s is invalid. Valid keys are: %s';
    const INVALID_FIELD = 'Fields: %s is invalid. Valid fields are: %s';

    public static function invalidDataType($field, $expectedDataType)
    {
        return sprintf('%s is expected to be a %s', $field, $expectedDataType);
    }
}
