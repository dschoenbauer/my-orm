<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Enum\SearchTypes;

/**
 * Description of WhereStatement
 *
 * @author David
 */
class WhereStatement
{

    const JOIN_TYPE_AND = 'and';
    const JOIN_TYPE_OR = 'or';

    use ArrayToKeyTrait;

    private $data;
    private $joinType;
    private $searchType;

    function __construct($arrayKeyValue, $joinType = self::JOIN_TYPE_AND, $searchType = SearchTypes::EQUAL)
    {
        $this->setData($arrayKeyValue)->setJoinType($joinType)->setSearchType($searchType);
    }

    public function getStatment()
    {
        $joiner = sprintf(" %s ", $this->getJoinType());
        return implode($joiner, $this->arrayToKeyedArray($this->getData(), $this->getSearchType()));
    }

    public function getParameters()
    {
        return $this->getData();
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getJoinType()
    {
        return $this->joinType;
    }

    public function setJoinType($joinType)
    {
        $this->joinType = $joinType;
        return $this;
    }

    public function getSearchType()
    {
        return $this->searchType;
    }

    public function setSearchType($searchType)
    {
        $this->searchType = $searchType;
        return $this;
    }
}
