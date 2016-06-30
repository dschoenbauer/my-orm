<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Connection\ConnectionVisitorInterface;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use PDO;

/**
 * Description of ErrorHandlerException
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class ErrorHandlerException implements ModelVisitorInterface, ConnectionVisitorInterface
{
    public function visitModel(Model $model)
    {
        $this->setErrorHandling($model->getQuery()->getAdapter());
    }

    public function visitConnection(PDO $pdo)
    {
        $this->setErrorHandling($pdo);
    }
    
    protected function setErrorHandling(PDO $pdo){
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
