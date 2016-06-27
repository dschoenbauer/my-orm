<?php namespace CTIMT\MyOrm\Visitor\DataType;

use CTIMT\MyOrm\Adapter\AbstractModelObserver;
use CTIMT\MyOrm\Entity\HasStringFieldsInterface;
use CTIMT\MyOrm\Exception\Visitor\DataType\InvalidDataTypeException;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of String
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class String extends AbstractModelObserver implements ModelVisitorInterface
{
    const TYPE = 'string';

    public function visitModel(Model $model)
    {
        if ($model->getEntity() instanceof HasStringFieldsInterface) {
            $model->attach($this);
        }
    }

    protected function updateObserver(Model $model)
    {
        $this->validate($model->getData(), $model->getEntity()->getStringFields());
    }

    public function validate($data, array $fields)
    {
        foreach ($fields as $field) {
            if (array_key_exists($field, $data) && !is_string($data[$field])) {
                throw new InvalidDataTypeException($field, self::TYPE);
            }
        }
        return true;
    }
}
