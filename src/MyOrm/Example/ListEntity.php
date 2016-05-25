<?php namespace CTIMT\MyOrm\Example;

use CTIMT\MyOrm\Adapter\Filter;
use CTIMT\MyOrm\Entity\AbstractEntity;
use CTIMT\MyOrm\Entity\HasBoolFieldsInterface;
use CTIMT\MyOrm\Entity\HasFilterInterface;
use CTIMT\MyOrm\Entity\HasNumericFieldsInterface;
use CTIMT\MyOrm\Entity\HasStringFieldsInterface;
use CTIMT\MyOrm\Entity\IsSortableInterface;
use CTIMT\MyOrm\Enum\SortKeys;
use CTIMT\MyOrm\Enum\SearchTypeMapping;

/**
 * Description of ListEntity
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class ListEntity extends AbstractEntity implements HasBoolFieldsInterface, HasStringFieldsInterface, HasNumericFieldsInterface, IsSortableInterface, HasFilterInterface
{

    public function __construct()
    {
        $this
            ->setIdField('list_id')
            ->setTable('list')
            ->setName('list');
    }

    public function getBoolFields()
    {
        return ['list_global'];
    }

    public function getNumericFields()
    {
        return ['project_id', 'list_id'];
    }

    public function getStringFields()
    {
        return ['list_name', 'list_desc'];
    }

    public function getDefaultSortDirection()
    {
        return SortKeys::SORT_DIRECTION_ASCENDING;
    }

    public function getDefaultSortField()
    {
        return 'list';
    }

    public function getSortFields()
    {
        return ['list_id', 'list_name'];
    }

    public function getFilters()
    {
        return ['list_id', 'list_name'];
    }
}
