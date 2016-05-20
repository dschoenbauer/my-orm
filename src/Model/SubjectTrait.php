<?php

namespace CTIMT\MyOrm\Model;

/**
 * Description of SubjectTrait
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
trait SubjectTrait {

    private $_observers = [];

    public function attach(ObserverInterface $observer) {
        $this->_observers[] = $observer;
    }

    public function detach(ObserverInterface $observer) {
        foreach ($this->_observers as $key => $val) {
            if ($val == $observer) {
                unset($this->_observers[$key]);
            }
        }
    }

    public function notify($event) {
        foreach ($this->_observers as $obs) {
            $obs->update($this, $event);
        }
    }

}
