<?php

namespace CTIMT\MyOrm\Model;

/**
 * Description of SubjectInterface
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
interface SubjectInterface {

    function attach(AbstractObserver $observer_in);
    function detach(AbstractObserver $observer_in);
    function notify();
    
}
