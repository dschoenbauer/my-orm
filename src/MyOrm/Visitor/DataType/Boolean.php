<?php namespace CTIMT\MyOrm\Visitor\DataType;

use CTIMT\MyOrm\Entity\HasBoolFieldsInterface;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Exception\Visitor\DataType\InvalidDataTypeException;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use CTIMT\MyOrm\Model\ObserverInterface;

/**
 * Description of Boolean
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Boolean implements ModelVisitorInterface, ObserverInterface
{

    public function visitModel(Model $model)
    {
        if ($model->getEntity() instanceof HasBoolFieldsInterface) {
            $model->attach($this);
        }
    }

    public function update(Model $model, $eventName)
    {
        if ($eventName == ModelEvents::VALIDATE) {
            $this->validate($model);
        }
    }

    protected function validate(Model $model)
    {
        $booleanFields = $model->getEntity()->getBoolFields();
        $data = $model->getData();
        foreach ($booleanFields as $field) {
            if (array_key_exists($field, $data) && !is_bool($data[$field])) {
                throw new InvalidDataTypeException($field, 'boolean');
            }
        }
    }
}
