<?php

namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Enum\LayoutKeys;
use CTIMT\MyOrm\Enum\ModelAttributes;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Exception\Adapter\InvalidFieldsFieldException;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use CTIMT\MyOrm\Model\ObserverInterface;

/**
 * Description of Fields
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Fields implements ModelVisitorInterface, SelectVisitorInterface, ObserverInterface {

    const FIELDS_HIDDEN= "hidden";
    const FIELDS_ACTIVE= "active";
    const FIELDS = "fields";

    private $_userLimitedFields = [];

    public function visitModel(Model $model) {
        $this->loadUserString($model->getAttribute(ModelAttributes::FIELDS, []), $model);
        $model->attach($this);
    }

    public function loadUserString($userString, Model $model) {
        $validFields = $model->getEntity()->getAllFields();
        $userFields = $this->parseFields($userString);
        $this->validateFields($validFields, $userFields);
        $this->setUserLimitedFields($userFields);
    }

    public function update(Model $model, $eventName) {
        if( count($this->getUserLimitedFields()) && in_array($eventName, [ModelEvents::LAYOUT_COLLECTION_APPLIED,  ModelEvents::LAYOUT_ENTITY_APPLIED])){
            $this->showFields($model);
        }
    }

    public function visitSelect(Select $select) {
        if(count($this->getUserLimitedFields())){
            $select->setFields($this->getUserLimitedFields());
        }
    }

    protected function parseFields($userString) {
        return array_filter(explode(',', $userString));
    }

    protected function validateFields($validFields, $userFields) {
        $inValidFields = array_diff($userFields, $validFields);
        if (count($inValidFields)) {
            throw new InvalidFieldsFieldException($inValidFields, $validFields);
        }
    }

    private function showFields(Model $model) {
        $data = $model->getData();
        $data[LayoutKeys::META_KEY][self::FIELDS][self::FIELDS_HIDDEN] = array_values(array_diff($model->getEntity()->getAllFields(), $this->getUserLimitedFields()));
        $data[LayoutKeys::META_KEY][self::FIELDS][self::FIELDS_ACTIVE] = $this->getUserLimitedFields();
        $model->setData($data);
    }
    
    public function getUserLimitedFields() {
        return $this->_userLimitedFields;
    }

    public function setUserLimitedFields($userLimitedFields) {
        $this->_userLimitedFields = $userLimitedFields;
        return $this;
    }


}
