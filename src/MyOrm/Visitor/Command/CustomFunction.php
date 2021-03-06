<?php

namespace CTIMT\MyOrm\Visitor\Command;

use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of CustomFunction
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class CustomFunction implements ModelVisitorInterface {

    private $_customFunction;

    public function __construct(callable $customFunction) {
        $this->setCustomFunction($customFunction);
    }

    public function getCustomFunction() {
        return $this->_customFunction;
    }

    public function setCustomFunction($customFunction) {
        $this->_customFunction = $customFunction;
        return $this;
    }

    public function visitModel(Model $model) {
        $funct = $this->getCustomFunction();
        $funct($model);
    }

}
