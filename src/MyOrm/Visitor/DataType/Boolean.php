<?php namespace CTIMT\MyOrm\Visitor\DataType;

use CTIMT\MyOrm\Adapter\AbstractAdapter;
use CTIMT\MyOrm\Entity\HasBoolFieldsInterface;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of Boolean
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Boolean extends AbstractAdapter implements ModelVisitorInterface
{

    public function visitModel(Model $model)
    {
        if ($model->getEntity() instanceof HasBoolFieldsInterface) {
            $model->attach($this);
        }
    }

    protected function updateObserver(Model $model)
    {
        $this->validate($model);
    }

    protected function validate(Model $model)
    {
        $booleanFields = $model->getEntity()->getBoolFields();
        $data = $model->getData();
        foreach ($booleanFields as $field) {
            if (array_key_exists($field, $data) && !is_bool($data[$field])) {
                $data[$field] = boolval($data[$field]);
            }
        }
        $model->setData($data);
    }
}
