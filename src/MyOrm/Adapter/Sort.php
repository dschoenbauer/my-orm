<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Adapter\Select;
use CTIMT\MyOrm\Adapter\SelectVisitorInterface;
use CTIMT\MyOrm\Entity\IsSortableInterface;
use CTIMT\MyOrm\Enum\LayoutKeys;
use CTIMT\MyOrm\Enum\ModelAttributes;
use CTIMT\MyOrm\Enum\SortKeys;
use CTIMT\MyOrm\Exception\Adapter\InvalidOrderKey;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/*
 * Copyright 2015 Coe-Truman International.
 */

/**
 * Description of Sort
 *
 * @author David
 */
class Sort extends AbstractAdapter implements SelectVisitorInterface, ModelVisitorInterface
{

    const KEY = 'sort';
    const SORT_FIELDS = "fields";
    const SORT_ACTIVE = "active";
    const DIRECTION_CHARACTER = '-';

    private $_allowedFields = [];
    private $_fields;

    public function visitSelect(Select $select)
    {
        $fields = $this->getFields();
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
        $this->setAllowedFields($allowedFields)->setFields($this->parseUrl($sort)? : []);
        $model->attach($this);
    }

    public function parseUrl($string)
    {
        $pieces = array_filter(explode(',', $string));
        $output = [];
        foreach ($pieces as $piece) {
            $output[trim($piece, self::DIRECTION_CHARACTER)] = strrpos($piece, self::DIRECTION_CHARACTER) === 0 ? SortKeys::SORT_DIRECTION_DESCENDING : SortKeys::SORT_DIRECTION_ASCENDING;
        }
        return $output;
    }

    protected function updateObserver(Model $model)
    {
        $model->setData($this->buildFormatForCollection($model->getData()));
    }

    public function buildFormatForCollection(array $data)
    {
        $data[LayoutKeys::META_KEY][self::KEY][self::SORT_ACTIVE] = $this->getFields();
        $data[LayoutKeys::META_KEY][self::KEY][self::SORT_FIELDS] = $this->getAllowedFields();
        return $data;
    }

    public function getFields()
    {
        return $this->_fields;
    }

    public function setFields(array $field)
    {
        $invalidFields = array_keys(array_diff_key($field, array_flip($this->getAllowedFields())));
        if (count($field) > 0 && count($invalidFields)) {
            throw new InvalidOrderKey($invalidFields, $this->getAllowedFields());
        }
        $this->_fields = $field;
        return $this;
    }

    public function getAllowedFields()
    {
        return $this->_allowedFields;
    }

    public function setAllowedFields(array $allowedFields)
    {
        $this->_allowedFields = $allowedFields;
        return $this;
    }
}
