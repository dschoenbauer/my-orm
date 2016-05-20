<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CTIMT\MyOrm\Visitor\Composite;

use CTIMT\MyOrm\Enum\ModelActions;
use CTIMT\MyOrm\Enum\ModelExecutionPriority;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use CTIMT\MyOrm\Visitor\Composite\Layout\Collection;
use CTIMT\MyOrm\Visitor\Composite\Layout\Entity;
use CTIMT\MyOrm\Visitor\Content\Create;
use CTIMT\MyOrm\Visitor\Content\Delete;
use CTIMT\MyOrm\Visitor\Content\Fetch;
use CTIMT\MyOrm\Visitor\Content\FetchAllFull;
use CTIMT\MyOrm\Visitor\Content\Update;

/**
 * Description of AddPersistanceActionsToModel
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class AddPersistanceActionsToModel implements ModelVisitorInterface{

    public function visitModel(Model $model) {
        $model->getActions()
                ->add(ModelActions::CREATE, new Create(), ModelExecutionPriority::ACTION)
                ->add(ModelActions::UPDATE, new Update(), ModelExecutionPriority::ACTION)
                ->add(ModelActions::DELETE, new Delete(), ModelExecutionPriority::ACTION)
                
                ->add(ModelActions::FETCH, new Fetch(), ModelExecutionPriority::ACTION)
                
                ->add(ModelActions::FETCH_ALL, new FetchAllFull(), ModelExecutionPriority::ACTION)
        ;
        $model->accept(new Entity());
        $model->accept(new Collection());
    }
}
