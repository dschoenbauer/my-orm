<?php namespace CTIMT\MyOrm\Builder;

use CTIMT\MyOrm\Entity\EntityInterface;
use PDO;

/**
 * Description of ModelDirector
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class ModelDirector
{

    private $builder;

    public function __construct(ModelBuilderInterface $builder)
    {
        $this->setBuilder($builder);
    }

    public function buildModel(EntityInterface $entity, PDO $pdo, $timeZone = null, $encodingProgram = 'UTF8', $encodingDb = 'utf8mb4')
    {
        return $this->getBuilder()
                ->createModel($entity, $pdo)
                ->setup($timeZone, $encodingProgram, $encodingDb)
                ->addDataTypeValidations()
                ->addPersistanceActions();
    }

    public function getResult()
    {
        return $this->getBuilder()->getModel();
    }

    /**
     * @return ModelBuilder
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    public function setBuilder($builder)
    {
        $this->builder = $builder;
        return $this;
    }
}
