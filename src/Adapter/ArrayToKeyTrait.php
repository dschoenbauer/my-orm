<?php

namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Enum\SearchTypes;

/**
 * Description of ArrayToKeyTrait
 *
 * @author David
 */
trait ArrayToKeyTrait {

    public function arrayToKeyedArray($data, $searchType = SearchTypes::EQUAL) {
        return array_map(function($value) use($searchType) {
            return sprintf($searchType, $value);
        }, array_keys($data));
    }

}
