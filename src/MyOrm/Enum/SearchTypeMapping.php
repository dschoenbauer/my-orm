<?php namespace CTIMT\MyOrm\Enum;

/**
 * Description of SearchTypeMapping
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class SearchTypeMapping
{

    public static function getMapping()
    {
        return [
            SearchTypeNames::CONTAINS => SearchTypes::CONTAINS,
            SearchTypeNames::ENDS_WITH => SearchTypes::ENDS_WITH,
            SearchTypeNames::EQUAL => SearchTypes::EQUAL,
            SearchTypeNames::GREATER_THAN => SearchTypes::GREATER_THAN,
            SearchTypeNames::GREATER_THAN_EQUAL_TO => SearchTypes::GREATER_THAN_EQUAL_TO,
            SearchTypeNames::LESS_THAN => SearchTypes::LESS_THAN,
            SearchTypeNames::LESS_THAN_EQUAL_TO => SearchTypes::LESS_THAN_EQUAL_TO,
            SearchTypeNames::NOT_EQUAL => SearchTypes::NOT_EQUAL,
            SearchTypeNames::STARTS_WITH => SearchTypes::STARTS_WITH,
        ];
    }

    public static function covertNameToExpression($name)
    {
        $mapping = self::getMapping();
        return array_key_exists($name, $mapping) ? $mapping[$name] : null;
    }

    public static function getKeys()
    {
        return array_keys(self::getMapping());
    }
}
