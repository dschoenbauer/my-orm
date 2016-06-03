<?php namespace CTIMT\MyOrm\Visitor\DataType;

use CTIMT\MyOrm\Adapter\AbstractAdapter;
use CTIMT\MyOrm\Entity\HasNumericFieldsInterface;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Exception\Visitor\DataType\InvalidDataTypeException;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of Numeric
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Numeric extends AbstractAdapter implements ModelVisitorInterface
{

    public function visitModel(Model $model)
    {
        if ($model->getEntity() instanceof HasNumericFieldsInterface) {
            $model->attach($this);
        }
    }

    protected function updateObserver(Model $model)
    {
        $this->validate($model);
    }

    public function validate(Model $model)
    {
        $numericFields = $model->getEntity()->getNumericFields();
        $data = $model->getData();
        foreach ($numericFields as $field) {
            if (array_key_exists($field, $data) && !is_numeric($data[$field])) {
                throw new InvalidDataTypeException($field, 'number');
            }
        }
    }
}
