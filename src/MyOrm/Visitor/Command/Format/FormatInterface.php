<?php

namespace CTIMT\MyOrm\Visitor\Command\Format;

/**
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
interface FormatInterface
{
    public function isRelevent($entity, $key, $value);
    public function format($value);
}
