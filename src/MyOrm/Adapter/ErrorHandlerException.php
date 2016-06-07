<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use PDO;

/**
 * Description of ErrorHandlerException
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class ErrorHandlerException implements ModelVisitorInterface
{
    public function visitModel(Model $model)
    {
        $model->getQuery()->getAdapter()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
