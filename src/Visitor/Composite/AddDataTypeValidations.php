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
use CTIMT\MyOrm\Visitor\Command\ValidateData;
use CTIMT\MyOrm\Visitor\Command\ValidFieldsFilter;
use CTIMT\MyOrm\Visitor\DataType\Boolean;
use CTIMT\MyOrm\Visitor\DataType\Date;
use CTIMT\MyOrm\Visitor\DataType\Numeric;
use CTIMT\MyOrm\Visitor\DataType\String;

/**
 * Adds validations for data types
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class AddDataTypeValidations implements ModelVisitorInterface {

    public function visitModel(Model $model) {
        $model
                ->accept(new ValidFieldsFilter())
                ->accept(new String())
                ->accept(new Date())
                ->accept(new Boolean())
                ->accept(new Numeric())
                ->getActions()
                    ->add(ModelActions::CREATE, New ValidateData(), ModelExecutionPriority::PRIOR_TO_ACTION)
                    ->add(ModelActions::UPDATE, New ValidateData(), ModelExecutionPriority::PRIOR_TO_ACTION)
                ;
    }

}
