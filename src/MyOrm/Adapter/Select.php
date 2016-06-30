<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Adapter\SelectVisitorInterface;
use CTIMT\MyOrm\Adapter\WhereStatement;
use CTIMT\MyOrm\Exception\Platform\LogicException;

/**
 * Description of Select
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Select
{

    const JOIN_INNER = 'INNER JOIN ';
    const JOIN_OUTER = 'OUTER JOIN ';
    const JOIN_LEFT = 'LEFT JOIN ';
    const JOIN_RIGHT = 'RIGHT JOIN ';
    const ORDER_ASCENDING = 'asc';
    const ORDER_DESCENDING = 'desc';

    private $_selectDirectives = [];
    private $_fields = [];
    private $_from = [];
    private $_where = [];
    private $_groupBy = [];
    private $_having = [];
    private $_sort = [];
    private $_footer = '';

    
    public function addDirective($directive){
        $this->_selectDirectives[] = $directive;
    }


    public function getFields()
    {
        return $this->_fields;
    }

    public function setFields(array $fields)
    {
        $this->_fields = $fields;
        return $this;
    }
    
    public function addField($field)
    {
        $this->_fields[] = $field;
        return $this;
    }

    public function addFrom($table, $alias = null)
    {
        $this->_from[] = sprintf('%s %s', $table, $alias);
        return $this;
    }

    public function addJoin($joinType, $table, $alias = null, $joinWhere = null)
    {
        $this->_from[] = sprintf('%s %s %s ON %s', $joinType, $table, $alias, $joinWhere);
        return $this;
    }

    private function getFrom()
    {
        return $this->_from;
    }

    /**
     * @return WhereStatement
     */
    public function getWhere()
    {
        return $this->_where;
    }

    public function setWhere(WhereStatement $where = null)
    {
        $this->_where = $where;
        return $this;
    }

    public function setGroupBy(array $fields)
    {
        $this->_groupBy = $fields;
        return $this;
    }

    public function getGroupBy()
    {
        return $this->_groupBy;
    }

    public function setHaving(array $fields)
    {
        $this->_having = $fields;
        return $this;
    }

    public function getHaving()
    {
        return $this->_having;
    }

    public function addSort($field, $order)
    {
        $this->_sort[] = sprintf('%s %s', $field, $order);
        return $this;
    }

    public function getSort()
    {
        return $this->_sort;
    }

    public function clearSort(){
        $this->_sort = [];
    }

    public function getSql()
    {
        if (!count($this->getFrom())) {
            throw new LogicException("You Must Define Tables To Select From");
        }
        $sql = 'SELECT ';
        $sql .= $this->getConvertedArray('', $this->getSelectDirectives(),' ');
        $sql .= $this->getConvertedArray('', $this->getFields());
        $sql .= $this->getConvertedArray('FROM', $this->getFrom(), PHP_EOL);
        if ($this->getWhere() instanceof WhereStatement) {
            $sql .= 'WHERE ' . $this->getWhere()->getStatment() . PHP_EOL;
        }
        $sql .= $this->getConvertedArray('GROUP BY', $this->getGroupBy());
        $sql .= $this->getConvertedArray('HAVING', $this->getHaving());
        $sql .= $this->getConvertedArray('ORDER BY', $this->getSort());
        $sql .= $this->getFooter();
        return $sql;
    }

    private function getConvertedArray($keyword, $array, $glue = ', ')
    {
        if (count($array) > 0) {
            return $keyword . ' ' . implode($glue, $array) . PHP_EOL;
        }
    }

    public function accept(SelectVisitorInterface $visitor)
    {
        $visitor->visitSelect($this);
        return $this;
    }
    
    public function getSelectDirectives()
    {
        return $this->_selectDirectives;
    }
    
    public function getFooter()
    {
        return $this->_footer;
    }

    public function setFooter($footer)
    {
        $this->_footer = $footer;
        return $this;
    }
}
