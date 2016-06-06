<?php namespace CTIMT\MyOrm\Visitor\DataType;

use CTIMT\MyOrm\Adapter\AbstractAdapter;
use CTIMT\MyOrm\Entity\HasNumericFieldsInterface;
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
    const TYPE = 'number';

    public function visitModel(Model $model)
    {
        if ($model->getEntity() instanceof HasNumericFieldsInterface) {
            $model->attach($this);
        }
    }

    protected function updateObserver(Model $model)
    {
        $this->validate($model->getData(), $model->getEntity()->getNumericFields());
    }

    public function validate(array $data, array $fields)
    {
        foreach ($fields as $field) {
            if (array_key_exists($field, $data) && !is_numeric($data[$field])) {
                throw new InvalidDataTypeException($field, self::TYPE);
            }
        }
        return true;
    }
}
