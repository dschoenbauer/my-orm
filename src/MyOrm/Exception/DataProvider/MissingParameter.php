<?php
namespace CTIMT\MyOrm\Exception\DataProvider;

use CTIMT\MyOrm\Enum\ErrorMessages;
use CTIMT\MyOrm\Exception\ExceptionInterface;
use CTIMT\MyOrm\Exception\Platform\LogicException;

/**
 * Description of MissingParameter
 *
 * @author David
 */
class MissingParameter extends LogicException implements ExceptionInterface {

    public function __construct(array $parameters) {
        $message = count($parameters) == 1 ? ErrorMessages::DATA_PROVIDER_MISSING_PARAMETER : ErrorMessages::DATA_PROVIDER_MISSING_PARAMETERS;
        parent::__construct(sprintf($message, implode(', ', $parameters)));
    }

}
