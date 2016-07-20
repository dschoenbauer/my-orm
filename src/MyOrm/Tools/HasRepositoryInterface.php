<?php namespace CTIMT\MyOrm\Tools;

use CTIMT\MyOrm\Tools\Repository;

/**
 * Description of HasRepositoryInterface
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
interface HasRepositoryInterface
{

    /**
     * @return Repository Description
     */
    public function getRepository();
    
    public function setRepository(Repository $repository);
}
