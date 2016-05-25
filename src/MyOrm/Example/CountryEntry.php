<?php namespace CTIMT\MyOrm\Example;

use CTIMT\MyOrm\Entity\AbstractEntity;
use CTIMT\MyOrm\Entity\HasBoolFieldsInterface;
use CTIMT\MyOrm\Entity\HasFilterInterface;
use CTIMT\MyOrm\Entity\HasNumericFieldsInterface;
use CTIMT\MyOrm\Entity\HasStringFieldsInterface;
use CTIMT\MyOrm\Entity\IsSortableInterface;

/**
 * Description of CountryEntry
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class CountryEntry extends AbstractEntity implements HasBoolFieldsInterface, HasStringFieldsInterface, HasFilterInterface, IsSortableInterface, HasNumericFieldsInterface
{

    public function __construct()
    {
        $this->setIdField('country_id')->setName('country')->setTable('country');
    }

    public function getBoolFields()
    {
        return [ 'country_requireState'];
    }

    public function getStringFields()
    {
        return ['country_name', 'country_abbrev2', 'country_abbrev3'];
    }

    public function getFilters()
    {
        return ['country_name', 'country_abbrev2'];
    }

    public function getDefaultSortDirection()
    {
        return "desc";
    }

    public function getDefaultSortField()
    {
        return "country_name";
    }

    public function getSortFields()
    {
        return ['country_name'];
    }

    public function getNumericFields()
    {
        return ['country_id'];
    }
}
