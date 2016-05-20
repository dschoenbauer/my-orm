<?php

namespace CTIMT\MyOrm\Entity;

/**
 * Description of AbstractEntity
 *
 * @author David
 */
abstract class AbstractEntity implements EntityInterface {

    private $_idField;
    private $_table;
    private $_name;

    function getIdField() {
        return $this->_idField;
    }

    function getTable() {
        return $this->_table;
    }

    function getName() {
        return $this->_name;
    }

    function setIdField($idField) {
        $this->_idField = $idField;
        return $this;
    }

    function setTable($table) {
        $this->_table = $table;
        return $this;
    }

    function setName($name) {
        $this->_name = $name;
        return $this;
    }

    public function getAllFields() {
        $fields = [];
        if ($this instanceof HasBoolFieldsInterface) {
            $fields = array_merge($fields, $this->getBoolFields());
        }
        if ($this instanceof HasDateFieldsInterface) {
            $fields = array_merge($fields, $this->getDateFields());
        }
        if ($this instanceof HasNumericFieldsInterface) {
            $fields = array_merge($fields, $this->getNumericFields());
        }
        if ($this instanceof HasStringFieldsInterface) {
            $fields = array_merge($fields, $this->getStringFields());
        }
        return $fields;
    }

}
