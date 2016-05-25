<?php namespace CTIMT\MyOrm\Visitor\Content;

use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of FetchAll
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class FetchAll implements ModelVisitorInterface
{

    public function visitModel(Model $model)
    {
        $fields = $model->getEntity()->getAllFields();
        $table = $model->getEntity()->getTable();
        $model->setData($model->getQuery()->select($table, $fields));
    }
}
