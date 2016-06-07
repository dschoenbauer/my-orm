<?php namespace CTIMT\MyOrm\Model;

use CTIMT\MyOrm\Adapter\Query;
use CTIMT\MyOrm\Entity\AbstractEntity;
use CTIMT\MyOrm\Enum\ModelActions;
use CTIMT\MyOrm\Enum\ModelEvents;
use Exception;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AbstractModel
 *
 * @author David
 */
class Model
{

    use SubjectTrait;

    private $_attributes = [];
    private $_actions;
    private $_entity;
    private $_query;
    private $_data;
    private $_id;

    public function __construct(AbstractEntity $entity, Query $query)
    {
        $this->setActions(new ActionCollection($this))->setEntity($entity)->setQuery($query);
    }

    public function create($data)
    {
        try {
            $this->setData($data)
                ->notify(ModelEvents::TRAMSACTION_START)
                ->getActions()->run(ModelActions::CREATE);
            $this->notify(ModelEvents::TRAMSACTION_COMPLETE);
        } catch (\Exception $exc) {
            $this->notify(ModelEvents::ERROR);
            throw $exc;
        }
        return $this->fetch($this->getId());
    }

    public function fetch($id)
    {
        $this->setId($id);
        $this->getActions()->run(ModelActions::FETCH);
        return $this->getData();
    }

    public function fetchAll()
    {
        $this->getActions()->run(ModelActions::FETCH_ALL);
        return $this->getData();
    }

    public function update($id, $data)
    {
        try {
            $this
                ->setId($id)
                ->setData($data)
                ->notify(ModelEvents::TRAMSACTION_START)
                ->getActions()->run(ModelActions::UPDATE);
            $this->notify(ModelEvents::TRAMSACTION_COMPLETE);
        } catch (Exception $exc) {
            $this->notify(ModelEvents::ERROR);
            throw $exc;
        }
        return $this->fetch($id);
    }

    public function delete($id)
    {
        try {
            $this->setId($id)->notify(ModelEvents::TRAMSACTION_START);
            $this->getActions()->run(ModelActions::DELETE);
            $this->notify(ModelEvents::TRAMSACTION_COMPLETE);
        } catch (Exception $exc) {
            $this->notify(ModelEvents::ERROR);
            throw $exc;
        }
        return true;
    }

    /**
     * @param type $entity
     * @return AbstractModel
     */
    public function setEntity(AbstractEntity $entity)
    {
        $this->_entity = $entity;
        return $this;
    }

    /**
     * @return AbstractEntity
     */
    public function getEntity()
    {
        return $this->_entity;
    }

    /**
     * @return Query
     */
    public function getQuery()
    {
        return $this->_query;
    }

    public function setQuery($query)
    {
        $this->_query = $query;
        return $this;
    }

    public function getData()
    {
        return $this->_data;
    }

    public function setData($data)
    {
        $this->_data = $data;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    /**
     * @return ActionCollection
     */
    public function getActions()
    {
        return $this->_actions;
    }

    public function setActions(ActionCollection $actions)
    {
        $this->_actions = $actions;
        return $this;
    }

    public function accept(ModelVisitorInterface $visitor)
    {
        $visitor->visitModel($this);
        return $this;
    }

    public function setAttribute($name, $value)
    {
        if (!array_key_exists($name, $this->_attributes)) {
            $this->_attributes[$name] = new Attribute($name, $value);
        }
        $this->_attributes[$name]->setValue($value);
        return $this;
    }

    public function getAttribute($name, $defaultValue = null)
    {
        return (array_key_exists($name, $this->_attributes) ? $this->_attributes[$name]->getValue() : $defaultValue);
    }

    public function getAttributeObject($name, $defaultValue = null)
    {
        if (!array_key_exists($name, $this->_attributes)) {
            $this->setAttribute($name, $defaultValue);
        }
        return $this->_attributes[$name];
    }
}
