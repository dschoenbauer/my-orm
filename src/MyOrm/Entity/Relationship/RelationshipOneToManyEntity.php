<?php namespace CTIMT\MyOrm\Entity\Relationship;

use CTIMT\MyOrm\Enum\LayoutKeys;

/**
 * Description of RelationshipOneToManyEntity
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class RelationshipOneToManyEntity extends AbstractRelationship
{

    protected function assignData(array $data, $linkingField, array $entityData, $name)
    {
        $defaultedData = array_map(function($row) use ($name){
            if(!isset($row[LayoutKeys::EMBEDDED_KEY][$name])){
                $row[LayoutKeys::EMBEDDED_KEY][$name] = [];
            }
            return $row;
        }, $data);
        foreach ($entityData as $row) {
            if (array_key_exists($linkingField, $row) && array_key_exists($row[$linkingField], $defaultedData)) {
                $defaultedData[$row[$linkingField]][LayoutKeys::EMBEDDED_KEY][$name][] = $row;
            }
        }

        return $defaultedData;
    }
}
