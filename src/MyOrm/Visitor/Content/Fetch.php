<?php

namespace CTIMT\MyOrm\Visitor\Content;

use CTIMT\MyOrm\Adapter\WhereStatement;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of Fetch
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Fetch implements ModelVisitorInterface {

    public function visitModel(Model $model) {
        $fields = $model->getEntity()->getAllFields();
        $table = $model->getEntity()->getTable();
        $where = new WhereStatement([$model->getEntity()->getIdField() => $model->getId()]);
        $model->setData($model->getQuery()->select($table, $fields, $where, true));
    }

}
