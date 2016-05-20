<?php

namespace CTIMT\MyOrm\Visitor\Content;

use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of Create
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Create implements ModelVisitorInterface {

    public function visitModel(Model $model) {
        $model->setId($model->getQuery()->insert($model->getEntity()->getTable(), $model->getData()));
    }

}
