<?php
namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Adapter\SelectVisitorInterface;
use CTIMT\MyOrm\Adapter\WhereStatement;
use CTIMT\MyOrm\Exception\Platform\LogicException;

/**
 * Description of Select
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Select {

    const JOIN_INNER = 'INNER JOIN ';
    const JOIN_OUTER = 'OUTER JOIN ';
    const JOIN_LEFT = 'LEFT JOIN ';
    const JOIN_RIGHT = 'RIGHT JOIN ';
    const ORDER_ASCENDING = 'asc';
    const ORDER_DESCENDING = 'desc';

    private $_distinct = false;
    private $_sqlCalcFoundRows = false;
    private $_fields = [];
    private $_from = [];
    private $_where = [];
    private $_groupBy = [];
    private $_having = [];
    private $_orderBy = [];
    private $_limit = null;

    public function getDistinct() {
        return $this->_distinct;
    }

    public function getSqlCalcFoundRows() {
        return $this->_sqlCalcFoundRows;
    }

    public function setDistinct($distinct = true) {
        $this->_distinct = $distinct;
        return $this;
    }

    public function setSqlCalcFoundRows($sqlCalcFoundRows = true) {
        $this->_sqlCalcFoundRows = $sqlCalcFoundRows;
        return $this;
    }

    public function getFields() {
        return $this->_fields;
    }

    public function setFields(array $fields) {
        $this->_fields = $fields;
        return $this;
    }

    public function addFrom($table, $alias = null) {
        $this->_from[] = sprintf('%s %s', $table, $alias);
        return $this;
    }

    public function addJoin($joinType, $table, $alias = null, $joinWhere = null) {
        $this->_from[] = sprintf('%s %s %s ON %s', $joinType, $table, $alias, $joinWhere);
        return $this;
    }

    private function getFrom() {
        return $this->_from;
    }

    /**
     * @return WhereStatement
     */
    public function getWhere() {
        return $this->_where;
    }

    public function setWhere(WhereStatement $where = null) {
        $this->_where = $where;
        return $this;
    }

    public function setGroupBy(array $fields) {
        $this->_groupBy = $fields;
        return $this;
    }

    public function getGroupBy() {
        return $this->_groupBy;
    }

    public function setHaving(array $fields) {
        $this->_having = $fields;
        return $this;
    }

    public function getHaving() {
        return $this->_having;
    }

    public function addSort($field, $order) {
        $this->_orderBy[] = sprintf('%s %s', $field, $order);
        return $this;
    }

    protected function getSort() {
        return $this->_orderBy;
    }

    public function setLimit($offset, $rowCount) {
        $this->_limit = sprintf("LIMIT %s, %s", $offset, $rowCount);
        return $this;
    }

    protected function getLimit() {
        return $this->_limit;
    }

    public function getSql() {
        if (!count($this->getFrom())) {
            throw new LogicException("You Must Define Tables To Select From");
        }
        $sql = "SELECT ";
        if ($this->getDistinct()) {
            $sql .= "DISTINCT";
        }
        if ($this->getSqlCalcFoundRows()) {
            $sql .= "SQL_CALC_FOUND_ROWS";
        }
        $sql .= $this->getConvertedArray('', $this->getFields());
        $sql .= $this->getConvertedArray('FROM', $this->getFrom(), PHP_EOL);
        if ($this->getWhere() instanceof WhereStatement) {
            $sql .= 'WHERE ' . $this->getWhere()->getStatment() . PHP_EOL;
        }
        $sql .= $this->getConvertedArray('GROUP BY', $this->getGroupBy());
        $sql .= $this->getConvertedArray('HAVING', $this->getHaving());
        $sql .= $this->getConvertedArray('ORDER BY', $this->getSort());

        if ($this->getLimit()) {
            $sql .= $this->getLimit() . PHP_EOL;
        }
        return $sql;
    }

    private function getConvertedArray($keyword, $array, $glue = ', ') {
        if (count($array) > 0) {
            return $keyword . ' ' . implode($glue, $array) . PHP_EOL;
        }
    }

    public function accept(SelectVisitorInterface $visitor) {
        $visitor->visitSelect($this);
        return $this;
    }

}
