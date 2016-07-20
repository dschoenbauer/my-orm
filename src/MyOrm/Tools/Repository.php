<?php namespace CTIMT\MyOrm\Tools;

/**
 * Description of Repository
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Repository
{

    private $_data = [];

    public function set($name, $value)
    {
        $this->_data[$name] = $value;
    }

    public function get($name, $defaultValue)
    {
        if (!array_key_exists($name, $this->_data)) {
            return $defaultValue;
        }
        return $this->_data[$name];
    }

    public function add($name, $value)
    {
        $existingValue = $this->get($name, []);
        if (!is_array($existingValue)) {
            $existingValue = [$existingValue];
        }
        $existingValue[] = $value;
        $this->set($name, $existingValue);
    }

    public function has($name, $value)
    {
        $existingValue = $this->get($name, null);
        if (is_array($existingValue)) {
            return in_array($value, $existingValue);
        }
        return $value == $existingValue;
    }
}
