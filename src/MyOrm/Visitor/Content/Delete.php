<?php namespace CTIMT\MyOrm\Visitor\Content;

use CTIMT\MyOrm\Adapter\WhereStatement;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of Delete
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Delete implements ModelVisitorInterface
{

    public function visitModel(Model $model)
    {
        $where = new WhereStatement([$model->getEntity()->getIdField() => $model->getId()]);
        $model->getQuery()->delete($model->getEntity()->getTable(), $where);
    }
}
