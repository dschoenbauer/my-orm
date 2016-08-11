<?php namespace CTIMT\MyOrm\Entity\Relationship;

use CTIMT\MyOrm\Adapter\Select;
use CTIMT\MyOrm\Adapter\WhereStatement;
use CTIMT\MyOrm\Entity\EntityInterface;
use CTIMT\MyOrm\Entity\HasDataRelationshipInterface;
use CTIMT\MyOrm\Entity\HasEntityInterface;
use CTIMT\MyOrm\Enum\SearchTypes;
use CTIMT\MyOrm\Tools\HasRepositoryInterface;
use PDO;

/**
 * Description of AbstractRelationship
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
abstract class AbstractRelationship implements DataRelationshipInterface, HasRepositoryInterface, HasEntityInterface
{

    use \CTIMT\MyOrm\Adapter\EmbeddedDataTrait;

    private $entity;
    private $linkingField;
    private $name;

    public function __construct($name, EntityInterface $entity, $linkingField)
    {
        $this->setEntity($entity)->setLinkingField($linkingField)->setName($name);
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function setEntity(EntityInterface $entity)
    {
        $this->entity = $entity;
        return $this;
    }

    public function getLinkingField()
    {
        return $this->linkingField;
    }

    public function setLinkingField($linkingField)
    {
        $this->linkingField = $linkingField;
        return $this;
    }

    public function addEmbeddedData(PDO $pdo, array $data)
    {
        if (count($data) == 0) {
            return $data;
        }
        $this->setAdapter($pdo);
        $values = array_unique(array_column($data, $this->getLinkingField()));
        $sql = $this->getSelectStatement($this->getEntity(), $values, $this->getLinkingField());
        $stmt = $pdo->prepare($sql->getSql());
        $stmt->execute();
        $entityData = $stmt->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);

        if ($this->getEntity() instanceof HasDataRelationshipInterface && $this->includeEmbeddedData()) {
            $entityData = $this->embedData($entityData, $this->getEntity()->getDataRelationships());
        }

        return $this->assignData($data, $this->getLinkingField(), $entityData, $this->getEntity()->getName());
    }

    protected function includeEmbeddedData(){
        return true;
    }


    abstract protected function assignData(array $data, $linkingField, array $entityData, $name);

    /**
     * @param EntityInterface $entity
     * @param type $values
     * @param type $linkingField
     * @return Select
     */
    protected function getSelectStatement(EntityInterface $entity, array $values, $linkingField)
    {
        $whereSnippet = '%1$s in(' . (implode(',', array_filter($values)) ? : -1) . ')';
        $where = new WhereStatement([$linkingField => null], WhereStatement::JOIN_TYPE_AND, SearchTypes::manual($whereSnippet));
        $select = new Select();
        $select
            ->setFields(array_merge([$entity->getIdField()], $entity->getAllFields()))
            ->addFrom($entity->getTable())
            ->setWhere($where);
        return $select;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
