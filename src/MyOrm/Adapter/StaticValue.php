<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Entity\HasStaticValuesInterface;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use CTIMT\MyOrm\Model\ObserverInterface;

/**
 * Description of StaticValue
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class StaticValue implements ModelVisitorInterface, ObserverInterface
{

    public function visitModel(Model $model)
    {
        if ($model->getEntity() instanceof HasStaticValuesInterface) {
            $model->attach($this);
        }
    }

    public function update(Model $model, $eventName)
    {
        if ($eventName == ModelEvents::VALIDATE) {
            $model->setData(array_merge($model->getData(), $model->getEntity()->getStaticValues()));
        }
    }
}
