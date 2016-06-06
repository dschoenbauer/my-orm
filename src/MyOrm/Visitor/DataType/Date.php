<?php namespace CTIMT\MyOrm\Visitor\DataType;

use CTIMT\MyOrm\Adapter\AbstractAdapter;
use CTIMT\MyOrm\Entity\HasDateFieldsInterface;
use CTIMT\MyOrm\Exception\Visitor\DataType\InvalidDataTypeException;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use DateTime;

/**
 * Description of Date
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Date extends AbstractAdapter implements ModelVisitorInterface
{

    public function visitModel(Model $model)
    {
        if ($model->getEntity() instanceof HasDateFieldsInterface) {
            $model->attach($this);
        }
    }

    protected function updateObserver(Model $model)
    {
        $this->validate($model->getData(), $model->getEntity()->getDateFields());
    }

    public function validate(array $data, array $fields)
    {

        foreach ($fields as $field) {
            if (array_key_exists($field, $data) && !$this->validateField($data[$field])) {
                throw new InvalidDataTypeException($field, 'date');
            }
        }
        return true;
    }

    private function validateField($value)
    {
        return (is_array($value) &&
            array_key_exists('date', $value) && is_string($value['date']) &&
            array_key_exists('timezone_type', $value) && is_numeric($value['timezone_type']) &&
            array_key_exists('timezone', $value) && is_string($value['timezone'])) || $value instanceof DateTime;
    }
}
