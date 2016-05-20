<?php

/*
 * Copyright 2015 Coe-Truman International.
 */

//Get Filter
//$this->setExternalFilter(filter_input(INPUT_GET, self::PARAM_KEY, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY));

namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Entity\HasFilterInterface;
use CTIMT\MyOrm\Enum\ModelAttributes;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Enum\SearchFields;
use CTIMT\MyOrm\Enum\SearchTypeMapping;
use CTIMT\MyOrm\Exception\Adapter\InvalidFilterFieldException;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use CTIMT\MyOrm\Model\ObserverInterface;

/**
 * Description of Filter
 *
 * @author David
 */
class FilterO implements SelectVisitorInterface, ModelVisitorInterface, ObserverInterface {

    const KEY = 'filter';
    const LABEL = 'label';
    const FIELD = 'field';
    const TYPES = 'operators';

    private $_searchableFields = [];
    private $_whereStatement = null;
    private $_userSearch;

    public function __construct() {
        $this->setUserSearch(null, null, null);
    }

    public function visitSelect(Select $select) {
        $select->setWhere($this->getWhereStatement());
    }


    
    public function visitModel(Model $model) {
        if(!$model->getEntity() instanceof HasFilterInterface){
            return;
        }
        $model->attach($this);
        $field =  $model->getAttribute(ModelAttributes::SEARCH_FIELD, null);
        $operator =  $model->getAttribute(ModelAttributes::SEARCH_TYPE);
        $value =  $model->getAttribute(ModelAttributes::SEARCH_VALUE, null);
        $this->setFilters($model->getEntity()->getFilters());
        if($field){
            $this->setUserFilter($operator, $field, $value);
        }
    }
    
    public function update(Model $model, $eventName) {
        if($eventName == ModelEvents::LAYOUT_COLLECTION_APPLIED){
            $this->addFilterToLayout($model);
        }
    }
    
    protected function addFilterToLayout(Model $model) {
        $data = $model->getData();
        $attributes = $this->getUserSearch();
        $attributes['fields'] = $this->_searchableFields;
        $data[self::KEY] = $attributes;
        $model->setData($data);
    }


    public static function buildFilter($field, array $searchTypes) {
        return [
            self::FIELD => $field,
            self::TYPES => $searchTypes
        ];
    }

    public function setUserFilter($searchType, $field, $value) {
        $validFields = array_column($this->_searchableFields, self::FIELD);
        if(!in_array($field, $validFields)){
            throw new InvalidFilterFieldException($field, $validFields);
        }
        $this->setUserSearch($searchType, $field, $value);
        $this->_whereStatement = new WhereStatement([$field => $value], WhereStatement::JOIN_TYPE_AND, SearchTypeMapping::covertNameToExpression($searchType));
    }

    public function addFilter($label, $field, array $searchTypes) {
        $this->_searchableFields[$field] = self::buildFilter($label, $field, $searchTypes);
    }

    public function setFilters(array $searchableFields) {
        $this->_searchableFields = $searchableFields;
        return $this;
    }

    public function getWhereStatement() {
        return $this->_whereStatement;
    }

    public function getUserSearch() {
        return $this->_userSearch;
    }

    public function setUserSearch($searchType, $field, $value) {
        $this->_userSearch = [
            SearchFields::FIELD => $field,
            SearchFields::OPERATOR => $searchType,
            SearchFields::VALUE => $value,
        ];
        return $this;
    }
}
