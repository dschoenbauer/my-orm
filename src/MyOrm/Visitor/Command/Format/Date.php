<?php namespace CTIMT\MyOrm\Visitor\Command\Format;

use CTIMT\MyOrm\Entity\HasDateFieldsInterface;
use CTIMT\MyOrm\Enum\Defaults;
use CTIMT\MyOrm\Enum\Formats;
use CTIMT\MyOrm\Enum\ModelAttributes;
use CTIMT\MyOrm\Model\Model;
use DateTime;
use DateTimeZone;

/**
 * Description of Date
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Date implements FormatInterface
{

    private $model;
    
    public function __construct(Model $model)
    {
        $this->setModel($model);
    }


    public function format($value)
    {
        $timeZone = $this->getModel()->getAttribute(ModelAttributes::TIME_ZONE, Defaults::TIME_ZONE);
        if ($value instanceof DateTime) {
            $value = new DateTime($value->format(Formats::MYSQL_DATE_TIME), new DateTimeZone($timeZone));
        } else {
            $value = new DateTime($value, new DateTimeZone($timeZone));
        }
        $value->offset = $value->format('P');
        $value->timezone_code = $value->format('T');
        return;
    }

    public function isRelevent($entity, $key, $value)
    {
        return $entity instanceof HasDateFieldsInterface &&
            in_array($key, $entity->getDateFields()) &&
            $value;
    }
    
    /**
     * 
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    public function setModel(Model $model)
    {
        $this->model = $model;
        return $this;
    }
}
