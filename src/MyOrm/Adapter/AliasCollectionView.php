<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Enum\LayoutKeys;
use CTIMT\MyOrm\Model\Model;

/**
 * Description of AliasCollectionView
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class AliasCollectionView extends Alias
{

    protected function updateObserver(Model $model)
    {
        $model->setData($this->addAliasToCollectionLayout($model->getData(), $model->getEntity()->getName()));
    }

    public function addAliasToCollectionLayout(array $data, $entityName)
    {
        $data[LayoutKeys::META_KEY][self::FIELD] = $this->getMapping();
        $data[$entityName] = $this->remapData($data[$entityName], $this->getMapping());
        return $data;
    }
}
