<?php namespace CTIMT\MyOrm\Adapter;

/**
 * Description of SqlVisitorInterface
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
interface SelectVisitorInterface
{

    /**
     * @codeCoverageIgnore
     */
    public function visitSelect(Select $select);
}
