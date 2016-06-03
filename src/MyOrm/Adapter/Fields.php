<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Enum\LayoutKeys;
use CTIMT\MyOrm\Enum\ModelAttributes;
use CTIMT\MyOrm\Exception\Adapter\InvalidFieldsFieldException;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of Fields
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Fields extends AbstractAdapter implements ModelVisitorInterface, SelectVisitorInterface
{

    const FIELDS_HIDDEN = "hidden";
    const FIELDS_ACTIVE = "active";
    const FIELDS = "fields";

    private $userLimitedFields = [];
    private $validFields = [];

    public function visitModel(Model $model)
    {
        $this
            ->setValidFields($model->getEntity()->getAllFields())
            ->setUserLimitedFields($this->parseFields($model->getAttribute(ModelAttributes::FIELDS, '')));
        if (count($this->getUserLimitedFields())) {
            $model->attach($this);
        }
    }

    protected function updateObserver(Model $model)
    {
        $model->setData($this->showFields($model->getData()));
    }

    public function visitSelect(Select $select)
    {
        if (count($this->getUserLimitedFields())) {
            $select->setFields($this->getUserLimitedFields());
        }
    }

    public function parseFields($userString)
    {
        return array_filter(explode(',', $userString));
    }

    protected function validateFields($userFields)
    {
        $inValidFields = array_diff($userFields, $this->getValidFields());
        if (count($inValidFields)) {
            throw new InvalidFieldsFieldException($inValidFields, $this->getValidFields());
        }
    }

    public function showFields(array $data)
    {
        $data[LayoutKeys::META_KEY][self::FIELDS][self::FIELDS_HIDDEN] = array_values(array_diff($this->getValidFields(), $this->getUserLimitedFields()));
        $data[LayoutKeys::META_KEY][self::FIELDS][self::FIELDS_ACTIVE] = $this->getUserLimitedFields();
        return $data;
    }

    public function getUserLimitedFields()
    {
        return $this->userLimitedFields;
    }

    public function setUserLimitedFields(array $userLimitedFields)
    {
        $this->validateFields($userLimitedFields);
        $this->userLimitedFields = $userLimitedFields;
        return $this;
    }

    public function getValidFields()
    {
        return $this->validFields;
    }

    public function setValidFields(array $validFields)
    {
        $this->validFields = $validFields;
        return $this;
    }
}
