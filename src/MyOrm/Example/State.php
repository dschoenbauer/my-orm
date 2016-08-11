<?php namespace CTIMT\MyOrm\Example;

use CTIMT\MyOrm\Entity\AbstractEntity;
use CTIMT\MyOrm\Entity\HasDataRelationshipInterface;
use CTIMT\MyOrm\Entity\HasNumericFieldsInterface;
use CTIMT\MyOrm\Entity\HasStringFieldsInterface;
use CTIMT\MyOrm\Entity\Relationship\RelationshipManyToOneEnity;

/**
 * Description of State
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class State extends AbstractEntity implements
HasNumericFieldsInterface, HasStringFieldsInterface, HasDataRelationshipInterface
{

    public function __construct()
    {
        $this->setIdField('state_id')->setName('state')->setTable('state');
    }

    public function getNumericFields()
    {
        return ['state_id', 'country_id'];
    }

    public function getStringFields()
    {
        return ['state_name', 'state_abbrev'];
    }

    public function getDataRelationships()
    {
        //return [];
        return [new RelationshipManyToOneEnity('CountryToState', New CountryEntry(), 'country_id')];
    }
}
