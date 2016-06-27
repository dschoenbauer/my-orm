<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Entity\HasFilterInterface;
use CTIMT\MyOrm\Enum\LayoutKeys;
use CTIMT\MyOrm\Enum\ModelAttributes;
use CTIMT\MyOrm\Enum\SearchTypes;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of Filter
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Filter extends AbstractModelObserver implements ModelVisitorInterface, SelectVisitorInterface
{

    const FIELD = 'filter';

    private $_searchKeyValue = [];
    private $_validFields = [];

    protected function updateObserver(Model $model)
    {
        $model->setData($this->addFilterToLayout($model->getData()));
    }

    public function visitModel(Model $model)
    {
        if ($model->getEntity() instanceof HasFilterInterface) {
            $model->attach($this);
            $this->setValidFields($model->getEntity()->getFilters());
            $this->setSearchKeyValue($model->getAttribute(ModelAttributes::FILTER, []));
        }
    }

    public function visitSelect(Select $select)
    {
        if (count($this->getSearchKeyValue())) {
            $select->setWhere(new WhereStatement($this->getSearchKeyValue(), WhereStatement::JOIN_TYPE_AND, SearchTypes::CONTAINS));
        }
    }

    public function addFilterToLayout(array $data)
    {
        $data[LayoutKeys::META_KEY][self::FIELD]['active'] = $this->getSearchKeyValue();
        $data[LayoutKeys::META_KEY][self::FIELD]['fields'] = $this->getValidFields();
        return $data;
    }

    public function getSearchKeyValue()
    {
        return $this->_searchKeyValue;
    }

    public function setSearchKeyValue(array $searchKeyValue)
    {
        $this->_searchKeyValue = $searchKeyValue;
        return $this;
    }

    public function getValidFields()
    {
        return $this->_validFields;
    }

    public function setValidFields(array $validFields)
    {
        $this->_validFields = $validFields;
        return $this;
    }
}
