<?php namespace CTIMT\MyOrm\Visitor\Content;

use CTIMT\MyOrm\Adapter\WhereStatement;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of Update
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Update implements ModelVisitorInterface
{

    public function visitModel(Model $model)
    {
        $table = $model->getEntity()->getTable();
        $where = new WhereStatement([$model->getEntity()->getIdField() => $model->getId()]);
        $model->getQuery()->update($table, $model->getData(), $where);
    }
}
