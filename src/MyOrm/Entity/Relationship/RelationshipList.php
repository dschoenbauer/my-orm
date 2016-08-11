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

    const FIELD_ID = 'id';
    const FIELD_TEXT = 'text';

    private $selectedKey = 'selected';
    private $orderByField;
    private $fieldId;
    private $fieldName;
    private $crossLinkField;

    public function __construct($name, EntityInterface $entity, $linkingField, $orderByField, $fieldId, $fieldName, $crossLinkField = null)
    {
        parent::__construct($name, $entity, $linkingField);
        $this
            ->setOrderByField($orderByField)
            ->setFieldId($fieldId)
            ->setFieldName($fieldName);
    }

    protected function assignData(array $data, $linkingField, array $entityData, $name)
    {
        $reducedEntityData = $this->reduceEntityData($entityData);
        foreach ($data as &$row) {
            $myEntityData = $reducedEntityData;
            if (array_key_exists($row[$linkingField], $myEntityData)) {
                $myEntityData[$row[$linkingField]][$this->getSelectedKey()] = true;
            }
            $row[LayoutKeys::EMBEDDED_KEY][$name] = array_values($myEntityData);
        }
        return $data;
    }

    protected function reduceEntityData($entityData)
    {
        return array_map(function($row) {
            return [
                self::FIELD_ID => $row[$this->getFieldId()],
                self::FIELD_TEXT => $row[$this->getFieldName()],
                $this->getSelectedKey() => false
            ];
        }, $entityData);
    }

    protected function includeEmbeddedData()
    {
        return false;
    }

    protected function getSelectStatement(EntityInterface $entity, array $values, $linkingField)
    {
        $select = new Select();
        $select
            ->setFields(array_merge([$entity->getIdField()], $entity->getAllFields()))
            ->addFrom($entity->getTable())
            ->addSort($this->getOrderByField(), SortKeys::SORT_DIRECTION_ASCENDING);
        /* if ($linkingField) {
          $whereSnippet = '%1$s in(' . (implode(',', array_filter($values)) ? : -1) . ')';
          $where = new WhereStatement([$linkingField => null], WhereStatement::JOIN_TYPE_AND, SearchTypes::manual($whereSnippet));
          $select->setWhere($where);
          } */
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

    public function getFieldId()
    {
        return $this->fieldId;
    }

    public function getFieldName()
    {
        return $this->fieldName;
    }

    public function setFieldId($fieldId)
    {
        $this->fieldId = $fieldId;
        return $this;
    }

    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;
        return $this;
    }
    
    public function getCrossLinkField()
    {
        return $this->crossLinkField;
    }

    public function setCrossLinkField($crossLinkField)
    {
        $this->crossLinkField = $crossLinkField;
        return $this;
    }


}
