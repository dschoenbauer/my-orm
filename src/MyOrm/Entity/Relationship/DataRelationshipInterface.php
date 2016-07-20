<?php namespace CTIMT\MyOrm\Entity\Relationship;

/**
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
interface DataRelationshipInterface
{
    public function addEmbeddedData(\PDO $pdo,array $data);
    public function getName();
}
