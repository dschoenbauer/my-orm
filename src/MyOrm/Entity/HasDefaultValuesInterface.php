<?php namespace CTIMT\MyOrm\Entity;

/**
 * Default values can be overridden. Static Values can not.
 * @author David
 */
interface HasDefaultValuesInterface
{

    /**
     * @return array key value pairs of default values
     */
    public function getDefaultValues();
}
