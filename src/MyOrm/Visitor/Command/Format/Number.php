<?php

namespace CTIMT\MyOrm\Visitor\Command\Format;

use CTIMT\MyOrm\Entity\HasNumericFieldsInterface;

/**
 * Description of Date
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Number implements FormatInterface
{
    public function format($value)
    {
        return (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }

    public function isRelevent($entity, $key, $value)
    {
        return $entity instanceof HasNumericFieldsInterface &&
                in_array($key, $entity->getNumericFields());
    }

}
