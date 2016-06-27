<?php namespace CTIMT\MyOrm\Builder;

use CTIMT\MyOrm\Entity\EntityInterface;
use PDO;

/**
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
interface ModelBuilderInterface
{
    public function createModel(EntityInterface $entity, PDO $pdo);
    public function setup($timeZone = null, $encoding = 'UTF8');
    public function prepareDataConnection($encoding = 'utf8mb4');
    public function addDataTypeValidations();
    public function addPersistanceActions();
    public function getModel();
}
