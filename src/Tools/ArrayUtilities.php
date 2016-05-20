<?php
namespace CTIMT\MyOrm\Tools;

/**
 * Description of Array
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class ArrayUtilities {
    public static function ModifyAndReturn($array, $field, $value){
        $array[$field] = $value;
        return $array;
    }
}
