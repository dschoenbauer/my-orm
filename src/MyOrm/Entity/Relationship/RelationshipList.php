<?php namespace CTIMT\MyOrm\Entity\Relationship;

use CTIMT\MyOrm\Adapter\Select;
use CTIMT\MyOrm\Entity\EntityInterface;
use CTIMT\MyOrm\Enum\LayoutKeys;
use CTIMT\MyOrm\Enum\SortKeys;

/**
 * Description of RelationshipList
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class RelationshipList extends AbstractRelationship
{

    private $selectedKey;
    private $orderByField;

    public function __construct($name, EntityInterface $entity, $linkingField, $orderByField, $selectedKey = 'selected')
    {
        parent::__construct($name, $entity, $linkingField);
        $this
            ->setSelectedKey($selectedKey)
            ->setOrderByField($orderByField);
    }

    protected function assignData(array $data, $linkingField, array $entityData, $name)
    {
        $defaultEntityData = array_map(function($row){
            
            $row[$this->getSelectedKey()] = false;
            return $row;
        }, $entityData);
        foreach ($data as &$row) {
            $myEntityData = $defaultEntityData;
            $myEntityData[$row[$linkingField]][$this->getSelectedKey()] = true;
            $row[LayoutKeys::EMBEDDED_KEY][$name] = array_values($myEntityData);
        }
        return $data;
        
    }

    protected function getSelectStatement(EntityInterface $entity, array $values, $linkingField)
    {
        $select = new Select();
        $select
            ->setFields(array_merge([$entity->getIdField()], $entity->getAllFields()))
            ->addFrom($entity->getTable())
            ->addSort($this->getOrderByField(), SortKeys::SORT_DIRECTION_ASCENDING);
        return $select;
    }
    
    public function getSelectedKey()
    {
        return $this->selectedKey;
    }

    public function setSelectedKey($selectedKey)
    {
        $this->selectedKey = $selectedKey;
        return $this;
    }

    public function getOrderByField()
    {
        return $this->orderByField;
    }

    public function setOrderByField($orderByField)
    {
        $this->orderByField = $orderByField;
        return $this;
    }
    
}
