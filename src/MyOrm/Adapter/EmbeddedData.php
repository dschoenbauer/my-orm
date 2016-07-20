<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Entity\HasDataRelationshipInterface;
use CTIMT\MyOrm\Enum\RepositoryKeys;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use CTIMT\MyOrm\Tools\HasRepositoryInterface;
use CTIMT\MyOrm\Tools\Repository;

/**
 * Description of EmbeddedData
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class EmbeddedData extends AbstractModelObserver implements ModelVisitorInterface, HasRepositoryInterface
{

    use EmbeddedDataTrait;

    public function __construct(array $eventNames,  Repository $repository)
    {
        parent::__construct($eventNames);
        $this->setRepository($repository);
    }

    protected function updateObserver(Model $model)
    {
        $this->getRepository()->add(RepositoryKeys::ENTITY, $model->getEntity());
        $model->setData($this->embedData($model->getData(), $model->getEntity()->getDataRelationships()));
        var_dump($this->getRepository());
    }

    public function visitModel(Model $model)
    {
        if ($model->getEntity() instanceof HasDataRelationshipInterface) {
            $model->attach($this);
            $this->setAdapter($model->getQuery()->getAdapter());
        }
    }
}
