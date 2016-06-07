<?php

namespace CTIMT\MyOrm\Visitor\Command\Format;

use CTIMT\MyOrm\Entity\HasBoolFieldsInterface;

/**
 * Description of Date
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Boolean implements FormatInterface
{
    public function format($value)
    {
        return boolval($value);
    }

    public function isRelevent($entity, $key, $value)
    {
        return $entity instanceof HasBoolFieldsInterface && 
            in_array($key, $entity->getBoolFields());
    }
}
