<?php

namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Enum\SearchTypes;

/**
 * Description of WhereStatement
 *
 * @author David
 */
class WhereStatement {

    const JOIN_TYPE_AND = 'and';
    const JOIN_TYPE_OR = 'or';

    use ArrayToKeyTrait;

    private $_data;
    private $_joinType;
    private $_searchType;

    function __construct($arrayKeyValue, $joinType = self::JOIN_TYPE_AND, $searchType = SearchTypes::EQUAL) {
        $this->setData($arrayKeyValue)->setJoinType($joinType)->setSearchType($searchType);
    }

    public function getStatment() {
        $joiner = sprintf(" %s ", $this->getJoinType());
        return implode($joiner, $this->arrayToKeyedArray($this->getData(), $this->getSearchType()));
    }

    public function getParameters() {
        return $this->getData();
    }

    public function getData() {
        return $this->_data;
    }

    public function setData($data) {
        $this->_data = $data;
        return $this;
    }

    public function getJoinType() {
        return $this->_joinType;
    }

    public function setJoinType($joinType) {
        $this->_joinType = $joinType;
        return $this;
    }

    public function getSearchType() {
        return $this->_searchType;
    }

    public function setSearchType($searchType) {
        $this->_searchType = $searchType;
        return $this;
    }

}
