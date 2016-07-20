<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CTIMT\MyOrm\Enum;

/**
 * Description of SearchType
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class SearchTypes
{

    const GREATER_THAN = '%1$s > :%1$s';
    const GREATER_THAN_EQUAL_TO = '%1$s >= :%1$s';
    const EQUAL = '%1$s = :%1$s';
    const NOT_EQUAL = '%1$s != :%1$s';
    const LESS_THAN = '%1$s < :%1$s';
    const LESS_THAN_EQUAL_TO = '%1$s <= :%1$s';
    const CONTAINS = '%1$s like concat(\'%%\', :%1$s, \'%%\')';
    const STARTS_WITH = '%1$s like concat(:%1$s, \'%%\')';
    const ENDS_WITH = '%1$s like concat(\'%%\', :%1$s)';
    public static function manual($sql){
        return $sql;
    }
}
