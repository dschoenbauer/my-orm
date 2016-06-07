<?php

namespace CTIMT\MyOrm\Visitor\Command\Format;

/**
 * Description of Date
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class String implements FormatInterface
{
    public function format($value)
    {
        return $value;
    }

    public function isRelevent($entity, $key, $value)
    {
        return true;
    }
//put your code here
}
