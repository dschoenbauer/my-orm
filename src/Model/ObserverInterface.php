<?php

namespace CTIMT\MyOrm\Model;

/**
 * Description of ObserverInterface
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
interface ObserverInterface {
    public function update(Model $model, $eventName);
}
