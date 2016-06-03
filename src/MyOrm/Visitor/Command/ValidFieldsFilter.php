<?php namespace CTIMT\MyOrm\Visitor\Command;

use CTIMT\MyOrm\Adapter\AbstractAdapter;
use CTIMT\MyOrm\Exception\Visitor\Command\NoValidFieldsException;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Validates that only fields defined on the entity are allowed to be accessed
 *
 * @author David
 */
class ValidFieldsFilter extends AbstractAdapter implements ModelVisitorInterface
{

    public function visitModel(Model $model)
    {
        $model->attach($this);
    }

    protected function updateObserver(Model $model)
    {
            $this->validate($model);        
    }

    private function validate($model)
    {
        $allfields = array_fill_keys($model->getEntity()->getAllFields(), null);
        $model->setData(array_intersect_key($model->getData(), $allfields));

        if (count($model->getData()) == 0) {
            throw new NoValidFieldsException;
        }
    }
}
