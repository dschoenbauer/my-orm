<?php namespace CTIMT\MyOrm\Example;

use CTIMT\MyOrm\Entity\AbstractEntity;
use CTIMT\MyOrm\Entity\HasDataRelationshipInterface;
use CTIMT\MyOrm\Entity\HasNumericFieldsInterface;
use CTIMT\MyOrm\Entity\HasStringFieldsInterface;
use CTIMT\MyOrm\Entity\Relationship\RelationshipList;
use CTIMT\MyOrm\Entity\Relationship\RelationshipManyToOneEnity;

/**
 *
  venue_id
  venue_name
  venue_description
  venue_address1
  venue_address2
  venue_city
  state_id
  country_id
  customer_id
  venue_zip
  timeZone_id
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Venue extends AbstractEntity implements HasNumericFieldsInterface, HasStringFieldsInterface, HasDataRelationshipInterface
{

    public function __construct()
    {
        $this->setIdField('venue_id')->setName('venue')->setTable('Venue');
    }

    public function getNumericFields()
    {
        return ['venue_id', 'state_id', 'country_id', 'customer_id', 'timeZone_id'];
    }

    public function getStringFields()
    {
        return ['venue_name', 'venue_description', 'venue_address1', 'venue_address2', 'venue_city', 'venue_zip'];
    }

    public function getDataRelationships()
    {
        return [
            new RelationshipList('VenueToState', new State(), 'state_id','state_name'),
            new RelationshipList('VenueToCountry', new CountryEntry(), 'country_id','country_name'),
        ];
    }
}
