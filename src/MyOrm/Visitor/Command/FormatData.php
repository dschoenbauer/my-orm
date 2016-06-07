<?php namespace CTIMT\MyOrm\Visitor\Command;

use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use CTIMT\MyOrm\Visitor\Command\Format\FormatInterface;

/**
 * Description of FormatData
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class FormatData implements ModelVisitorInterface
{

    private $formats = [];

    public function visitModel(Model $model)
    {
        $model->setData($this->formatData($model->getData(), $model->getEntity()));
    }

    public function add(FormatInterface $format)
    {
        $this->formats[] = $format;
        return $this;
    }

    public function formatData(array $data, $entity)
    {
        $formats = $this->formats;
        array_walk_recursive($data, function (&$value, $key) use ($entity, $formats) {
            foreach($formats as $format){
            /* @var $format FormatInterface */
                if($format->isRelevent($entity, $key, $value)){
                    $value = $format->format($value);
                    return;
                }
            }
        });
        return $data;
    }
}
