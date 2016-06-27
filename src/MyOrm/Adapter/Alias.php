<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Enum\ModelAttributes;
use CTIMT\MyOrm\Exception\Adapter\InvalidAliasKeyException;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of Alias
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Alias extends AbstractModelObserver implements ModelVisitorInterface
{

    const FIELD = "alias";

    private $_mapping = [];

    protected function updateObserver(Model $model)
    {
        $model->setData($this->reverseAlias($model->getData()));
    }

    /**
     * @covers CTIMT\MyOrm\Adapter\Alias::visitModel
     */
    public function visitModel(Model $model)
    {
        $validFields = $model->getEntity()->getAllFields();
        $userFields = $model->getAttribute(ModelAttributes::ALIAS, []);
        $this->setMapping($this->validateMapping($userFields, $validFields));
        if (count($this->getMapping()))
            $model->attach($this);
        return null;
    }

    public function reverseAlias(array $data)
    {
        $mapping = array_flip($this->getMapping());
        return $this->remapRow($data, $mapping);
    }

    public function remapData(array $data)
    {
        $mapping = $this->getMapping();
        foreach ($data as $key => $row) {
            $data[$key] = $this->remapRow($row, $mapping);
        }
        return $data;
    }

    public function remapRow(array $row, $mapping)
    {
        $newRow = [];
        foreach ($row as $key => $value) {
            $newRow[array_key_exists($key, $mapping) ? $mapping[$key] : $key] = $value;
        }
        return $newRow;
    }

    public function validateMapping(array $userAliases, array $validFields)
    {
        $aliases = array_keys($userAliases);
        $invalidFields = array_diff($aliases, $validFields);
        if (count($invalidFields)) {
            throw new InvalidAliasKeyException($invalidFields, $validFields);
        }
        return $userAliases;
    }

    public function getMapping()
    {
        return $this->_mapping;
    }

    public function setMapping(array $mapping)
    {
        $this->_mapping = $mapping;
        return $this;
    }
}
