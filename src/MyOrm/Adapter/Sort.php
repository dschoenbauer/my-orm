<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Adapter\Select;
use CTIMT\MyOrm\Adapter\SelectVisitorInterface;
use CTIMT\MyOrm\Entity\IsSortableInterface;
use CTIMT\MyOrm\Enum\LayoutKeys;
use CTIMT\MyOrm\Enum\ModelAttributes;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Enum\SortKeys;
use CTIMT\MyOrm\Exception\Adapter\InvalidOrderKey;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use CTIMT\MyOrm\Model\ObserverInterface;

/*
 * Copyright 2015 Coe-Truman International.
 */

/**
 * Description of Sort
 *
 * @author David
 */
class Sort implements SelectVisitorInterface, ModelVisitorInterface, ObserverInterface
{

    const KEY = 'sort';
    const SORT_FIELDS = "fields";
    const DIRECTION_CHARACTER = '-';

    private $_allowedFields = [];
    private $_field;

    public function visitSelect(Select $select)
    {
        $fields = $this->getField();
        if (count($fields)) {
            foreach ($fields as $field => $direction) {
                $select->addSort($field, $direction);
            }
        }
    }

    public function visitModel(Model $model)
    {
        if (!$model->getEntity() instanceof IsSortableInterface) {
            return;
        }
        $sort = $model->getAttribute(ModelAttributes::SORT);
        $allowedFields = $model->getEntity()->getSortFields();
        $this->setAllowedFields($allowedFields)->setField($this->parseUrl($sort)? : []);
        $model->attach($this);
    }

    protected function parseUrl($string)
    {
        $pieces = array_filter(explode(',', $string));
        $output = [];
        foreach ($pieces as $piece) {
            $output[trim($piece, self::DIRECTION_CHARACTER)] = strrpos($piece, self::DIRECTION_CHARACTER) === 0 ? SortKeys::SORT_DIRECTION_DESCENDING : SortKeys::SORT_DIRECTION_ASCENDING;
        }
        return $output;
    }

    public function update(Model $model, $eventName)
    {
        if ($eventName == ModelEvents::LAYOUT_COLLECTION_APPLIED) {
            $this->buildFormatForCollection($model);
        }
    }

    protected function buildFormatForCollection(Model $model)
    {
        $data = $model->getData();
        $data[LayoutKeys::META_KEY][self::KEY]['active'] = $this->getField();
        $data[LayoutKeys::META_KEY][self::KEY][self::SORT_FIELDS] = $this->getAllowedFields();
        $model->setData($data);
    }

    public function getField()
    {
        return $this->_field;
    }

    public function setField(array $field)
    {
        $invalidFields = array_keys(array_diff_key($field, array_flip($this->getAllowedFields())));
        if (count($field) > 0 && count($invalidFields)) {
            throw new InvalidOrderKey($invalidFields, $this->getAllowedFields());
        }
        $this->_field = $field;
        return $this;
    }

    public function getAllowedFields()
    {
        return array_keys($this->_allowedFields);
    }

    public function setAllowedFields(array $allowedFields)
    {
        $fields = [];
        foreach ($allowedFields as $field => $value) {
            $fields[(is_numeric($field) ? $value : $field)] = $value;
        }
        $this->_allowedFields = $fields;
        return $this;
    }
}
