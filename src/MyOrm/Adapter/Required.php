<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Entity\HasRequiredFieldsInterface;
use CTIMT\MyOrm\Exception\Adapter\MissingPayloadKeyException;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of Required
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Required extends AbstractModelObserver implements ModelVisitorInterface
{

    public function visitModel(Model $model)
    {
        if ($model->getEntity() instanceof HasRequiredFieldsInterface) {
            $model->attach($this);
        }
    }

    protected function updateObserver(Model $model)
    {
        $this->validate(array_keys($model->getData()), $model->getEntity()->getRequiredFields() );
    }

    public function validate(array $currentFields, array $requiredFields)
    {
        $missingFields = array_diff($requiredFields, $currentFields);
        if (count($missingFields)) {
            throw new MissingPayloadKeyException($missingFields, $requiredFields);
        }
        return true;
    }
}
