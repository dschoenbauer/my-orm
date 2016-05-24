<?php

namespace CTIMT\MyOrm\Visitor\Content;

use CTIMT\MyOrm\Adapter\WhereStatement;
use CTIMT\MyOrm\Model\Model;

/**
 * Description of Fetch
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Fetch extends FetchAllFull {

    protected function runTemplate(Model $model) {
        $this->setFetchFlat();
        $where = new WhereStatement([$model->getEntity()->getIdField() => $model->getId()]);
        $this->getSelect()->setWhere($where);
    }

}
