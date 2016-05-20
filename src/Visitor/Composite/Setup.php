<?php
namespace CTIMT\MyOrm\Visitor\Composite;

use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use CTIMT\MyOrm\Visitor\Composite\Setup\TimeZone;
use CTIMT\MyOrm\Visitor\Composite\Setup\TimeZoneDb;
use CTIMT\MyOrm\Visitor\Composite\Setup\UserInput;
use CTIMT\MyOrm\Visitor\Composite\Setup\Utf8;
use PDO;


/**
 * Description of Setup
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Setup implements ModelVisitorInterface {

    public function visitModel(Model $model) {
        $model->getQuery()->getAdapter()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $model
                ->accept(new TimeZone())
                ->accept(new TimeZoneDb())
                ->accept(New Utf8())
                ->accept(new UserInput());
                ;
    }
}
