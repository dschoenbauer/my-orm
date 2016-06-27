<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of TransactionCommit
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class TransactionCommit extends AbstractModelObserver implements ModelVisitorInterface
{
    public function visitModel(Model $model)
    {
        $model->attach($this);
    }

    protected function updateObserver(Model $model)
    {
        $model->getQuery()->getAdapter()->commit();
    }
}
