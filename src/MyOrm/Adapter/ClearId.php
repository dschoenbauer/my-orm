<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use CTIMT\MyOrm\Model\ObserverInterface;

/**
 * The value in the ID field should never change. This removes it from the dataset
 * allowing it to remain the same
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class ClearId implements ModelVisitorInterface, ObserverInterface
{

    public function visitModel(Model $model)
    {
        $model->attach($this);
    }

    public function update(Model $model, $eventName)
    {
        if ($eventName == ModelEvents::VALIDATE) {
            $data = $model->getData();
            unset($data[$model->getEntity()->getIdField()]);
            $model->setData($data);
        }
    }
}
