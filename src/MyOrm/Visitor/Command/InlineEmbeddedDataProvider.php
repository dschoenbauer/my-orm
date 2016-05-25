<?php namespace CTIMT\MyOrm\Visitor\Command;

use CTIMT\MyOrm\Entity\EntityInterface;
use CTIMT\MyOrm\Enum\LayoutKeys;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of InlineEmbeddedDataProvider
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class InlineEmbeddedDataProvider implements ModelVisitorInterface
{

    private $_entities = [];

    public function __construct(EntityInterface $embeddedEntity)
    {
        $this->addEmbeddedEntity($embeddedEntity);
    }

    public function visitModel(Model $model)
    {
        $model->setData($this->buildInline($model->getData(), $model->getEntity()));
    }

    private function buildInline($data, EntityInterface $entity)
    {
        $compiledData = array_intersect_key($data, array_fill_keys($entity->getAllFields(), null));

        $entities = $this->getEntities();
        /* @var $entity EntityInterface */
        foreach ($entities as $entity) {
            $compiledData[LayoutKeys::EMBEDDED_KEY][$entity->getName()] = array_intersect_key($data, array_fill_keys($entity->getAllFields(), null));
        }
        return $compiledData;
    }

    public function getEntities()
    {
        return $this->_entities;
    }

    public function addEmbeddedEntity(EntityInterface $embeddedEntity)
    {
        $this->_entities[] = $embeddedEntity;
    }
}
