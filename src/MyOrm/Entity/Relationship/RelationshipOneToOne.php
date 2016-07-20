<?php namespace CTIMT\MyOrm\Entity\Relationship;

use CTIMT\MyOrm\Entity\EntityInterface;

/**
 * Description of RelationshipOne
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class RelationshipOneToOne
{

    private $mainDataField;
    private $linkedEntityField;
    private $entity;

    public function __construct($mainDataField, $linkedEntityField, EntityInterface $entity)
    {
        $this
            ->setMainDataField($mainDataField)
            ->setLinkedEntityField($linkedEntityField)
            ->setEntity($entity);
    }

    public function getMainDataField()
    {
        return $this->mainDataField;
    }

    public function getLinkedEntityField()
    {
        return $this->linkedEntityField;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function setMainDataField($mainDataField)
    {
        $this->mainDataField = $mainDataField;
        return $this;
    }

    public function setLinkedEntityField($linkedEntityField)
    {
        $this->linkedEntityField = $linkedEntityField;
        return $this;
    }

    public function setEntity(EntityInterface $entity)
    {
        $this->entity = $entity;
        return $this;
    }
}
