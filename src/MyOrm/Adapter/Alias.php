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
            $this->addAliasToCollectionLayout($model);
        }

        if ($eventName == ModelEvents::LAYOUT_ENTITY_APPLIED) {
            $this->addAliasToEntityLayout($model);
        }

        if ($eventName == ModelEvents::VALIDATE) {
            $this->reverseAlias($model);
        }
    }

    public function visitModel(Model $model)
    {
        $this->setMapping($this->validateMapping($model, ModelAttributes::ALIAS));
        if (count($this->getMapping())) {
            $model->attach($this);
        }
    }

    protected function addAliasToCollectionLayout(Model $model)
    {
        $data = $model->getData();
        $data[LayoutKeys::META_KEY][self::FIELD] = $this->getMapping();
        $content = $data[$model->getEntity()->getName()];
        $data[$model->getEntity()->getName()] = $this->remapData($content, $this->getMapping());
        $model->setData($data);
    }

    protected function addAliasToEntityLayout(Model $model)
    {
        $data = $model->getData();
        $data[LayoutKeys::META_KEY][self::FIELD] = $this->getMapping();
        $model->setData($this->remapRow($data, $this->getMapping()));
    }

    protected function reverseAlias(Model $model)
    {
        $mapping = array_flip($this->getMapping());
        $model->setData($this->remapRow($model->getData(), $mapping));
    }

    protected function remapData(array $data, array $mapping)
    {
        foreach ($data as $key => $row) {
            $data[$key] = $this->remapRow($row, $mapping);
        }
        return $data;
    }

    protected function remapRow(array $row, array $mapping)
    {
        $newRow = [];
        foreach ($row as $key => $value) {
            $newRow[array_key_exists($key, $mapping) ? $mapping[$key] : $key] = $value;
        }
        return $newRow;
    }

    protected function validateMapping(Model $model, $attributeName)
    {
        $aliases = array_keys($model->getAttribute($attributeName, []));
        $validFields = $model->getEntity()->getAllFields();
        $invalidFields = array_diff($aliases, $validFields);
        if (count($invalidFields)) {
            throw new InvalidAliasKeyException($invalidFields, $validFields);
        }
        return $model->getAttribute($attributeName, []);
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
