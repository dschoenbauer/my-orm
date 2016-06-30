<?php namespace CTIMT\MyOrm\Adapter\PaginationStrategy;

use CTIMT\MyOrm\Adapter\Pagination;
use CTIMT\MyOrm\Adapter\Select;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ObserverInterface;

/**
 * Description of SqlServer
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class SqlServer implements PaginationStrategyInterface, ObserverInterface
{

    const FIELD_TOTAL_COUNT = '_total_count';
    const FIELD_ROW_NUM = '_row_num';

    private $idField;
    private $pagination;

    public function getDriverName()
    {
        return 'sqlsrv';
    }

    public function visitSelect(Select $select)
    {
        $sort = implode(',', $select->getSort())? : $this->getIdField();
        $select->addDirective('* FROM (SELECT ');
        $select->addField("ROW_NUMBER() OVER ( ORDER BY {$sort} ) AS " . self::FIELD_ROW_NUM);
        $select->addField(self::FIELD_TOTAL_COUNT . " = Count(*) Over()");
        $start = ($this->getPagination()->getPage() - 1) * $this->getPagination()->getPageSize();
        $stop = $this->getPagination()->getPage() * $this->getPagination()->getPageSize();
        $select->setFooter(sprintf(') AS RowConstrainedResult WHERE %1$s > %2$s AND %1$s <= %3$s ORDER BY %1$s', self::FIELD_ROW_NUM, $start, $stop));
        $select->clearSort();
    }

    /**
     * @return Pagination
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    public function setPagination(Pagination $pagination)
    {
        $this->pagination = $pagination;
        return $this;
    }

    public function visitModel(Model $model)
    {
        $this->setIdField($model->getEntity()->getIdField());
        $model->attach($this);
    }

    private function getIdField()
    {
        return $this->idField;
    }

    private function setIdField($idField)
    {
        $this->idField = $idField;
        return $this;
    }

    public function update(Model $model, $eventName)
    {
        if ($eventName == ModelEvents::PRIMARY_DATA_PULLED) {
            $this->extractTotalRecords($model->getData());
            $model->setData($this->cleanData($model->getData()));
        }
    }

    private function extractTotalRecords($data)
    {
        $element = current($data)? : [];
        $totalResults = array_key_exists(self::FIELD_TOTAL_COUNT, $element) ? $element[self::FIELD_TOTAL_COUNT] : 0;
        $this->getPagination()->setTotalResults($totalResults);
    }

    private function cleanData(array $data)
    {
        return array_map(function($row) {
            unset($row[self::FIELD_ROW_NUM]);
            unset($row[self::FIELD_TOTAL_COUNT]);
            return $row;
        }, $data);
    }
}
