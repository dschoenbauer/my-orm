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
class Required extends AbstractAdapter implements ModelVisitorInterface
{

    public function visitModel(Model $model)
    {
        if ($model->getEntity() instanceof HasRequiredFieldsInterface) {
            $model->attach($this);
        }
    }

    protected function updateObserver(Model $model)
    {
        $this->validateFields($model->getEntity()->getRequiredFields(), array_keys($model->getData()));
    }

    protected function validateFields(array $requiredFields, array $currentFields)
    {
        $missingFields = array_diff($requiredFields, $currentFields);
        if (count($missingFields)) {
            throw new MissingPayloadKeyException($missingFields, $requiredFields);
        }
    }
}
