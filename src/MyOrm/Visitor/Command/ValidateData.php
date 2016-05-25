<?php namespace CTIMT\MyOrm\Visitor\Command;

use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of ValidateData
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class ValidateData implements ModelVisitorInterface
{

    public function visitModel(Model $model)
    {
        $model->notify(ModelEvents::VALIDATE);
    }
}
