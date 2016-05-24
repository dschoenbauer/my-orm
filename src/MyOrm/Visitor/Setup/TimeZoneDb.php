<?php

namespace CTIMT\MyOrm\Visitor\Setup;

use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of TimeZoneDb
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class TimeZoneDb implements ModelVisitorInterface {

    public function visitModel(Model $model) {
        $timezone = date('P');
        $model->getQuery()->getAdapter()->exec("SET time_zone = '{$timezone}'");
    }

}
