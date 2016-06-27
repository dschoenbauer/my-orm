<?php namespace CTIMT\MyOrm\Connection;

/**
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
interface ConnectionVisitorInterface
{

    public function visitConnection(\PDO $pdo);
    
}
