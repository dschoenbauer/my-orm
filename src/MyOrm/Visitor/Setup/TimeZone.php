<?php namespace CTIMT\MyOrm\Visitor\Setup;

use CTIMT\MyOrm\Enum\ModelAttributes;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of TimeZone
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class TimeZone implements ModelVisitorInterface
{

    private $timeZone = null;

    public function __construct($timeZone = null)
    {
        $this->setTimeZone($timeZone ? : date_default_timezone_get());
    }

    public function getTimeZone()
    {
        return $this->timeZone;
    }

    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
        return $this;
    }

    public function visitModel(Model $model)
    {
        $model->setAttribute(ModelAttributes::TIME_ZONE, $this->getTimeZone());
    }
}
