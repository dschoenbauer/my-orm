<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ObserverInterface;

/**
 * Description of AbstractAdapter
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
abstract class AbstractModelObserver implements ObserverInterface
{

    private $_eventNames = [];

    public function __construct(array $eventNames = [])
    {
        $this->setEventNames($eventNames);
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

    public function update(Model $model, $eventName)
    {
        if (in_array($eventName, $this->getEventNames())) {
            $this->updateObserver($model);
        }
        return true;
    }

    abstract protected function updateObserver(Model $model);
}
