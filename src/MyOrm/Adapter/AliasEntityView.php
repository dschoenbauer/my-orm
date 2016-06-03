<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Enum\LayoutKeys;
use CTIMT\MyOrm\Model\Model;

/**
 * Description of AliasEntityView
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class AliasEntityView extends Alias
{

    protected function updateObserver(Model $model)
    {
        $model->setData($this->addAliasToEntityLayout($model->getData()));
    }

    public function addAliasToEntityLayout(array $data)
    {
        $data[LayoutKeys::META_KEY][self::FIELD] = $this->getMapping();
        return $this->remapRow($data, $this->getMapping());
    }
}
