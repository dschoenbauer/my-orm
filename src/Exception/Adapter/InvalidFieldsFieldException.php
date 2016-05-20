<?php

namespace CTIMT\MyOrm\Exception\Adapter;

use CTIMT\MyOrm\Enum\ErrorMessages;
use CTIMT\MyOrm\Exception\Http\UnprocessableEntity;

/**
 * Description of InvalidSearchFieldException
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class InvalidFieldsFieldException extends UnprocessableEntity {
    public function __construct($invalidKey, $validKeys) {
        $message = sprintf(ErrorMessages::INVALID_FIELD, implode(',',$invalidKey), implode(', ', $validKeys));
        parent::__construct($message);
    }
}
