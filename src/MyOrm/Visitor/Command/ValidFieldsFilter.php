<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CTIMT\MyOrm\Visitor\Command;

use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Exception\Visitor\Command\NoValidFieldsException;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use CTIMT\MyOrm\Model\ObserverInterface;

/**
 * Validates that only fields defined on the entity are allowed to be accessed
 *
 * @author David
 */
class ValidFieldsFilter implements ModelVisitorInterface, ObserverInterface{
    
    public function visitModel(Model $model) {
        $model->attach($this);
    }

    public function update(Model $model, $eventName) {
        if($eventName == ModelEvents::VALIDATE){
            $this->validate($model);
        }
    }

    private function validate($model){
        $allfields = array_fill_keys($model->getEntity()->getAllFields(), null);
        $model->setData(array_intersect_key($model->getData(),$allfields));
        
        if (count($model->getData()) == 0) {
            throw new NoValidFieldsException;
        }        
    }

}
