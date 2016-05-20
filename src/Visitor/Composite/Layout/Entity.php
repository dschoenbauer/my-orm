<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CTIMT\MyOrm\Visitor\Composite\Layout;

use CTIMT\MyOrm\Enum\ModelActions;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Enum\ModelExecutionPriority;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
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
;
        $model->notify(ModelEvents::LAYOUT_ENTITY_APPLIED);
    }

}
