<?php

namespace CTIMT\MyOrm\Visitor\DataType;

use CTIMT\MyOrm\Entity\HasDateFieldsInterface;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Exception\Visitor\DataType\InvalidDataTypeException;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use CTIMT\MyOrm\Model\ObserverInterface;
use DateTime;

/**
 * Description of Date
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Date implements ModelVisitorInterface, ObserverInterface {

    public function visitModel(Model $model) {
        if ($model->getEntity() instanceof HasDateFieldsInterface) {
            $model->accept($this);
        }
    }

    public function update(Model $model, $eventName) {
        if($eventName == ModelEvents::VALIDATE){
            $this->validate($model);
        }
    }

    private function validate(Model $model) {
        $dateFields = $model->getEntity()->getDateFields();
        $data = $model->getData();
        foreach ($dateFields as $field) {
            if (array_key_exists($field, $data) && !$this->validateField($data[$field])) {
                throw new InvalidDataTypeException($field, 'date');
            }
        }
    }

    private function validateField($value) {
        return (is_array($value) &&
                array_key_exists('date', $value) && is_string($value['date']) &&
                array_key_exists('timezone_type', $value) && is_numeric($value['timezone_type']) &&
                array_key_exists('timezone', $value) && is_string($value['timezone'])) || $value instanceof DateTime;
    }

}
