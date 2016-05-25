<?php namespace CTIMT\MyOrm\Visitor\Command;

use CTIMT\MyOrm\Entity\HasBoolFieldsInterface;
use CTIMT\MyOrm\Entity\HasDateFieldsInterface;
use CTIMT\MyOrm\Entity\HasNumericFieldsInterface;
use CTIMT\MyOrm\Enum\Defaults;
use CTIMT\MyOrm\Enum\Formats;
use CTIMT\MyOrm\Enum\ModelAttributes;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use DateTime;
use DateTimeZone;

/**
 * Description of FormatData
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class FormatData implements ModelVisitorInterface
{

    public function visitModel(Model $model)
    {
        $data = $model->getData();
        array_walk_recursive($data, function (&$value, $key) use ($model) {
            if ($model->getEntity() instanceof HasBoolFieldsInterface &&
                in_array($key, $model->getEntity()->getBoolFields())) {
                $value = boolval($value);
                return;
            }
            if ($value == '' || $value === null || $value === 'null') {
                $value = null;
                return;
            }
            if ($model->getEntity() instanceof HasNumericFieldsInterface &&
                in_array($key, $model->getEntity()->getNumericFields())) {
                $value = (int) $value;
                return;
            }
            if ($model->getEntity() instanceof HasDateFieldsInterface &&
                in_array($key, $model->getEntity()->getDateFields()) &&
                $value) {
                $timeZone = $model->getAttribute(ModelAttributes::TIME_ZONE, Defaults::TIME_ZONE);
                if ($value instanceof DateTime) {
                    $value = new DateTime($value->format(Formats::MYSQL_DATE_TIME), new DateTimeZone($timeZone));
                } else {
                    $value = new DateTime($value, new DateTimeZone($timeZone));
                }
                $value->offset = $value->format('P');
                $value->timezone_code = $value->format('T');
                return;
            }
        });
        $model->setData($data);
    }
}
