<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CTIMT\MyOrm\Model;

/**
 *
 * @author David
 */
interface ModelVisitorInterface {

    public function visitModel(Model $model);
}
