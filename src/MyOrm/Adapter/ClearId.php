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
class ClearId extends AbstractAdapter implements ModelVisitorInterface, ObserverInterface
{

    public function visitModel(Model $model)
    {
        $model->attach($this);
    }

    protected function updateObserver(Model $model)
    {
        $model->setData($this->clearField($model->getData(), $model->getEntity()->getIdField()));
    }

    public function clearField(array $data, $id)
    {
        unset($data[$id]);
        return $data;
    }
}
