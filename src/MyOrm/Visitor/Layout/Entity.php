<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CTIMT\MyOrm\Visitor\Layout;

use CTIMT\MyOrm\Enum\ModelActions;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Enum\ModelExecutionPriority;
use CTIMT\MyOrm\Enum\Settings;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use CTIMT\MyOrm\Visitor\Command\CustomFunction;
use CTIMT\MyOrm\Visitor\Command\FormatData;

/**
 * Description of Entity
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Entity implements ModelVisitorInterface {

    public function visitModel(Model $model) {
        $model->getActions()
                ->add(ModelActions::FETCH, new FormatData(), ModelExecutionPriority::AFTER_ACTION)
                ->add(ModelActions::FETCH, new CustomFunction(function(Model $model){
                    $model->setData(array_values($model->getData())[0]?:[]);
                }), ModelExecutionPriority::AFTER_ACTION)
                ->add(ModelActions::FETCH, new CustomFunction(function(Model $model){
                    $data = $model->getData();
                    unset($data[Settings::ROW_ID]);
                    $model->setData($data);
                    $model->notify(ModelEvents::LAYOUT_ENTITY_APPLIED);
                }), ModelExecutionPriority::AFTER_ACTION)
;
    }

}