<?php namespace CTIMT\MyOrm\Adapter;

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

    private $_eventNames = [];

    public function __construct(array $eventNames = [])
    {
        $this->setEventNames($eventNames);
    }
    

    public function visitModel(Model $model)
    {
        $model->attach($this);
    }

    public function update(Model $model, $eventName)
    {
        if (in_array($eventName,$this->getEventNames())) {
            $model->setData($this->clearField($model->getData(), $model->getEntity()->getIdField()));
        }
    }

    public function clearField(array $data, $id)
    {
        unset($data[$id]);
        return $data;
    }

    public function getEventNames()
    {
        return $this->_eventNames;
    }

    public function setEventNames(array $eventNames)
    {
        $this->_eventNames = $eventNames;
        return $this;
    }
}
