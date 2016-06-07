<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Entity\HasStaticValuesInterface;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of StaticValue
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class StaticValue extends AbstractAdapter implements ModelVisitorInterface
{

    public function visitModel(Model $model)
    {
        if ($model->getEntity() instanceof HasStaticValuesInterface) {
            $model->attach($this);
        }
    }

    protected function updateObserver(Model $model)
    {
        $model->setData($this->applyStaticValues($model->getData(), $model->getEntity()->getStaticValues()));
    }

    public function applyStaticValues(array $data, array $staticData)
    {
        return array_merge($data, $staticData);
    }
}
