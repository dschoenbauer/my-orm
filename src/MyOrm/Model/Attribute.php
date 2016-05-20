<?php

namespace CTIMT\MyOrm\Model;

/**
 * Description of Attribute
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Attribute {
    private $_name;
    private $_value;
    
    public function __construct($name, $value) {
        $this->setName($name)->setValue($value);
    }

    public function getName() {
        return $this->_name;
    }

    public function getValue() {
        return $this->_value;
    }

    public function setName($name) {
        $this->_name = $name;
        return $this;
    }

    public function setValue($value) {
        $this->_value = $value;
        return $this;
    }
}
