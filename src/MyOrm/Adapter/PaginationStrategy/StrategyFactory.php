<?php namespace CTIMT\MyOrm\Adapter\PaginationStrategy;

use CTIMT\MyOrm\Adapter\Pagination;
use CTIMT\MyOrm\Adapter\Select;
use CTIMT\MyOrm\Model\Model;
use PDO;

/**
 * Description of StrategyFactory
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class StrategyFactory implements PaginationStrategyInterface
{
    private $_strategy;
    private $_driverName;

    public function __construct(PDO $pdo, array $stategies = [])
    {
        $this->setDriverName($pdo->getAttribute(PDO::ATTR_DRIVER_NAME));
        foreach ($stategies as $strategy) {
            /* @var $stategy PaginationStrategyInterface */
            if ($strategy->getDriverName() === $this->getDriverName()) {
                $this->setStrategy($strategy);
            }
        }
    }

    public function getDriverName()
    {
        return $this->_driverName;
    }

    public function setDriverName($driverName)
    {
        $this->_driverName = $driverName;
        return $this;
    }
    
    public function getTotalResults(Pagination $pagination)
    {
        $this->getStrategy()->getTotalResults($pagination);
    }

    public function visitSelect(Select $select)
    {
        $this->getStrategy()->visitSelect($select);
    }

    /**
     * 
     * @return PaginationStrategyInterface
     */
    private function getStrategy()
    {
        return $this->_strategy;
    }

    private function setStrategy($strategy)
    {
        $this->_strategy = $strategy;
        return $this;
    }

    public function setPagination(Pagination $pagination)
    {
        $this->getStrategy()->setPagination($pagination);
    }

    public function visitModel(Model $model)
    {
        $this->getStrategy()->visitModel($model);
    }
}
