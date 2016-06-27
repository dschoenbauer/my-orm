<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Entity\HasDefaultValuesInterface;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of DefaultValue
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class DefaultValue extends AbstractModelObserver implements ModelVisitorInterface
{

    public function visitModel(Model $model)
    {
        if ($model->getEntity() instanceof HasDefaultValuesInterface) {
            $model->attach($this);
        }
    }

    protected function updateObserver(Model $model)
    {
        $model->setData($this->getDefaultValue($model->getEntity()->getDefaultValues(), $model->getData()));
    }
    
    public function getDefaultValue(array $data,array $defaultValues){
        return array_merge($defaultValues, $data);
    }
}
