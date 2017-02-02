<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CTIMT\MyOrm\Visitor\Command;

use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of RemoveKeys
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class RemoveKeys implements ModelVisitorInterface {

    public function visitModel(Model $model) {
        $model->setData(array_values($model->getData()));
    }

}
