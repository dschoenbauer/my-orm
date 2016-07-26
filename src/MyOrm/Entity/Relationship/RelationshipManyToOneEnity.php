<?php namespace CTIMT\MyOrm\Entity\Relationship;

use CTIMT\MyOrm\Enum\LayoutKeys;

/**
 * Description of Relationship
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class RelationshipManyToOneEnity extends AbstractRelationship
{
    protected function assignData(array $data, $linkingField, array $entityData, $name)
    {
        foreach ($data as &$row){
            $row[LayoutKeys::EMBEDDED_KEY][$name] = null;
            if(array_key_exists($linkingField, $row) && array_key_exists($row[$linkingField], $entityData)){
                $row[LayoutKeys::EMBEDDED_KEY][$name] = $entityData[$row[$linkingField]];
            }
        }
        return $data;
    }

}
