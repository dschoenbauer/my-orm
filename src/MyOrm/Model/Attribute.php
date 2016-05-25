<?php namespace CTIMT\MyOrm\Model;

/**
 * Description of Attribute
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Attribute
{

    private $name;
    private $value;

    public function __construct($name, $value)
    {
        $this->setName($name)->setValue($value);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
