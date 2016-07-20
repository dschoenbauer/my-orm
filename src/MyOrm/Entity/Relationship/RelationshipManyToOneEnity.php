<?php namespace CTIMT\MyOrm\Entity\Relationship;

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
            $row['_embedded'][$name] = null;
            if(array_key_exists($linkingField, $row) && array_key_exists($row[$linkingField], $entityData)){
                $row['_embedded'][$name] = $entityData[$row[$linkingField]];
            }
        }
        return $data;
    }

}
