<?php namespace CTIMT\MyOrm\Visitor\Setup;

use CTIMT\MyOrm\Connection\ConnectionVisitorInterface;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of TimeZoneDb
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class TimeZoneDb implements ModelVisitorInterface,  ConnectionVisitorInterface
{

    public function visitModel(Model $model)
    {
        $this->setTimeZone($model->getQuery()->getAdapter());
    }

    public function visitConnection(\PDO $pdo)
    {
        $this->setTimeZone($pdo);
    }
    
    protected function setTimeZone(\PDO $pdo){
        $timezone = date('P');
        $pdo->exec("SET time_zone = '{$timezone}'");
    }
}
