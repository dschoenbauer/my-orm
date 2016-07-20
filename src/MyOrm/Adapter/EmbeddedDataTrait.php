<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Entity\HasEntityInterface;
use CTIMT\MyOrm\Entity\Relationship\DataRelationshipInterface;
use CTIMT\MyOrm\Enum\RepositoryKeys;
use CTIMT\MyOrm\Tools\HasRepositoryInterface;
use CTIMT\MyOrm\Tools\Repository;
use PDO;

/**
 * Description of EmbeddedDataTrait
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
trait EmbeddedDataTrait
{


    private $repository;
    private $adapter;

    public function embedData($data, array $dataRelationships)
    {
        foreach ($dataRelationships as $dataRelationship) {
            if ($dataRelationship instanceof HasRepositoryInterface) {
                $dataRelationship->setRepository($this->getRepository());
            }
            if (!$this->getRepository()->has(RepositoryKeys::NAME, $dataRelationship->getName())) {
                $this->getRepository()->add(RepositoryKeys::NAME, $dataRelationship->getName());
                $data = $dataRelationship->addEmbeddedData($this->getAdapter(), $data);
                $this->logEntity($dataRelationship);
            }
        }
        return $data;
    }

    private function logEntity(DataRelationshipInterface $dataRelationship)
    {
        if (
            $dataRelationship instanceof HasEntityInterface &&
            $dataRelationship instanceof HasRepositoryInterface
        ) {
            $dataRelationship
                ->getRepository()
                ->add(RepositoryKeys::ENTITY, $dataRelationship->getEntity());
        }
    }
    /**
     * @return PDO
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param PDO $adapter
     * @return EmbeddedData
     */
    public function setAdapter(PDO $adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }

    /**
     * @return Repository 
     */
    public function getRepository()
    {
        return $this->repository;
    }

    public function setRepository(Repository $repository)
    {
        $this->repository = $repository;
        return $this;
    }
}
