<?php namespace CTIMT\MyOrm\Visitor\DataType;

use CTIMT\MyOrm\Adapter\AbstractAdapter;
use CTIMT\MyOrm\Entity\HasBoolFieldsInterface;
use CTIMT\MyOrm\Exception\Visitor\DataType\InvalidDataTypeException;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of Boolean
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Boolean extends AbstractAdapter implements ModelVisitorInterface
{
    const TYPE = "boolean";

    public function visitModel(Model $model)
    {
        if ($model->getEntity() instanceof HasBoolFieldsInterface) {
            $model->attach($this);
        }
    }

    protected function updateObserver(Model $model)
    {
        $this->validate($model->getData(),$model->getEntity()->getBoolFields());
    }

    public function validate(array $data, array $fields)
    {
        foreach ($fields as $field) {
            if (array_key_exists($field, $data) && !is_bool($data[$field])) {
                throw new InvalidDataTypeException($field, self::TYPE);
            }
        }
        return true;
    }
}
