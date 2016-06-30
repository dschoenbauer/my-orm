<?php namespace CTIMT\MyOrm\Adapter\PaginationStrategy;

use CTIMT\MyOrm\Adapter\Pagination;
use CTIMT\MyOrm\Adapter\SelectVisitorInterface;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
interface PaginationStrategyInterface extends SelectVisitorInterface,  ModelVisitorInterface
{
    public function getDriverName();
    public function setPagination(Pagination $pagination);
}
