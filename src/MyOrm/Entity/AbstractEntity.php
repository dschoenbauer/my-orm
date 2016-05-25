<?php namespace CTIMT\MyOrm\Entity;

/**
 * Description of AbstractEntity
 *
 * @author David
 */
abstract class AbstractEntity implements EntityInterface
{

    private $idField;
    private $table;
    private $name;

    function getIdField()
    {
        return $this->idField;
    }

    function getTable()
    {
        return $this->table;
    }

    function getName()
    {
        return $this->name;
    }

    function setIdField($idField)
    {
        $this->idField = $idField;
        return $this;
    }

    function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getAllFields()
    {
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
