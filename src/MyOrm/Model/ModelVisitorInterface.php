<?php namespace CTIMT\MyOrm\Model;

/**
 * Provides a visitor interface to the Model Object
 * @author David
 */
interface ModelVisitorInterface
{

    public function visitModel(Model $model);
}
