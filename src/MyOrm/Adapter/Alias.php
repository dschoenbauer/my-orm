<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Enum\LayoutKeys;
use CTIMT\MyOrm\Enum\ModelAttributes;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Exception\Adapter\InvalidAliasKeyException;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use CTIMT\MyOrm\Model\ObserverInterface;

/**
 * Description of Alias
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Alias implements ModelVisitorInterface, ObserverInterface
{

    const FIELD = "alias";

    private $_mapping = [];

    public function update(Model $model, $eventName)
    {
        if ($eventName == ModelEvents::LAYOUT_COLLECTION_APPLIED) {
            $model->setData($this->addAliasToCollectionLayout($model->getData(), $model->getEntity()->getName()));
        }

        if ($eventName == ModelEvents::LAYOUT_ENTITY_APPLIED) {
            $model->setData($this->addAliasToEntityLayout($model->getData()));
        }

        if ($eventName == ModelEvents::VALIDATE) {
            $model->setData($this->reverseAlias($model->getData()));
        }
        return true;
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

    public function addAliasToCollectionLayout(array $data, $entityName)
    {
        $data[LayoutKeys::META_KEY][self::FIELD] = $this->getMapping();
        $content = $data[$entityName];
        $data[$entityName] = $this->remapData($content, $this->getMapping());
        return $data;
    }

    public function addAliasToEntityLayout(array $data)
    {
        $data[LayoutKeys::META_KEY][self::FIELD] = $this->getMapping();
        return $this->remapRow($data, $this->getMapping());
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
