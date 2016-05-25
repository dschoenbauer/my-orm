<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Entity\HasDefaultValuesInterface;
use CTIMT\MyOrm\Enum\ModelActions;
use CTIMT\MyOrm\Enum\ModelAttributes;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use CTIMT\MyOrm\Model\ObserverInterface;

/**
 * Description of DefaultValue
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class DefaultValue implements ModelVisitorInterface, ObserverInterface
{

    public function visitModel(Model $model)
    {
        if ($model->getEntity() instanceof HasDefaultValuesInterface) {
            $model->attach($this);
        }
    }

    public function update(Model $model, $eventName)
    {
        if ($eventName == ModelEvents::VALIDATE && $model->getAttribute(ModelAttributes::MODEL_ACTION) == ModelActions::CREATE) {
            $model->setData(array_merge($model->getEntity()->getDefaultValues(),$model->getData()));
        }
    }
}
