<?php

namespace CTIMT\MyOrm\Visitor\Layout;

use CTIMT\MyOrm\Enum\LayoutKeys;
use CTIMT\MyOrm\Enum\ModelActions;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Enum\ModelExecutionPriority;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use CTIMT\MyOrm\Visitor\Command\CustomFunction;
use CTIMT\MyOrm\Visitor\Command\FormatData;
use CTIMT\MyOrm\Visitor\Command\RemoveKeys;

/**
 * Description of Collection
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Collection implements ModelVisitorInterface {

    public function visitModel(Model $model) {
        $model->getActions()
                ->add(ModelActions::FETCH_ALL, new FormatData(), ModelExecutionPriority::AFTER_ACTION)
                ->add(ModelActions::FETCH_ALL, new RemoveKeys(), ModelExecutionPriority::AFTER_ACTION)
                ->add(ModelActions::FETCH_ALL, new CustomFunction(function(Model $model){
                    $output = [LayoutKeys::EMBEDDED_KEY => [], LayoutKeys::LINK_KEY => [], LayoutKeys::META_KEY => []];
                    $output[$model->getEntity()->getName()] = $model->getData();
                    $model->setData($output);
                    $model->notify(ModelEvents::LAYOUT_COLLECTION_APPLIED);
                }), ModelExecutionPriority::AFTER_ACTION) 
        ;
    }

}
