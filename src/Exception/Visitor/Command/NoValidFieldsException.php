<?php
namespace CTIMT\MyOrm\Exception\Visitor\Command;

use CTIMT\MyOrm\Enum\ErrorMessages;
use CTIMT\MyOrm\Exception\Http\UnprocessableEntity;

/**
 * Description of NoValidFields
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class NoValidFieldsException extends UnprocessableEntity {

    public function __construct() {
        parent::__construct(ErrorMessages::NO_VALID_FIELDS);
    }

}
