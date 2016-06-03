<?php namespace CTIMT\MyOrm\Visitor\DataType;

use CTIMT\MyOrm\Adapter\AbstractAdapter;
use CTIMT\MyOrm\Entity\HasStringFieldsInterface;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Exception\Http\InvalidDataTypeException;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of String
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class String extends AbstractAdapter implements ModelVisitorInterface
{

    public function visitModel(Model $model)
    {
        if ($model->getEntity() instanceof HasStringFieldsInterface) {
            $model->attach($this);
        }
    }

    protected function updateObserver(Model $model)
    {
            $this->validate($model);        
    }

    private function validate(Model $model)
    {
        $stringFields = $model->getEntity()->getStringFields();
        $data = $model->getData();
        foreach ($stringFields as $field) {
            if (array_key_exists($field, $data) && !is_string($data[$field])) {
                throw new InvalidDataTypeException($field, 'string');
            }
        }
    }
}
