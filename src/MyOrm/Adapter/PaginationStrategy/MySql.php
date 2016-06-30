<?php namespace CTIMT\MyOrm\Adapter\PaginationStrategy;

use CTIMT\MyOrm\Adapter\Pagination;
use CTIMT\MyOrm\Adapter\Select;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Enum\SelectDirectives;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ObserverInterface;
use PDO;

/**
 * Description of MySql
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class MySql implements PaginationStrategyInterface, ObserverInterface
{

    private $pagination;

    public function getDriverName()
    {
        return 'mysql';
    }

    public function visitSelect(Select $select)
    {
        $select->addDirective(SelectDirectives::SQL_CALC_FOUND_ROWS);
        $this->addFooter($select);
    }

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
        $model->attach($this);
    }

    public function update(Model $model, $eventName)
    {
        if ($eventName == ModelEvents::PRIMARY_DATA_PULLED) {
            $this->setTotals($model->getQuery()->getAdapter());
        }
    }

    public function setTotals(PDO $adapter)
    {
        $stmt = $adapter->query('SELECT FOUND_ROWS()');
        $this->getPagination()->setTotalResults($stmt ? $stmt->fetch(PDO::FETCH_COLUMN) : 0);
        return $this;
    }

    public function addFooter(Select $select)
    {
        $offset = $this->getPagination()->getPageSize() * ($this->getPagination()->getPage() - 1);
        $rowCount = $this->getPagination()->getPageSize();
        $select->setFooter(sprintf("LIMIT %s, %s", $offset, $rowCount));
    }
}
