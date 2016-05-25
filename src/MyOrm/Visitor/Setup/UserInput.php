<?php namespace CTIMT\MyOrm\Visitor\Setup;

use CTIMT\MyOrm\Enum\ModelAttributes;
use CTIMT\MyOrm\Enum\UserInterface;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of UserInput
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class UserInput implements ModelVisitorInterface
{

    public function visitModel(Model $model)
    {
        $model->setAttribute(ModelAttributes::FIELDS, filter_input(INPUT_GET, UserInterface::FIELDS, FILTER_SANITIZE_STRING) ? : null);
        $model->setAttribute(ModelAttributes::FILTER, filter_input(INPUT_GET, UserInterface::FILTER, FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY) ? : []);
        $model->setAttribute(ModelAttributes::ALIAS, filter_input(INPUT_GET, UserInterface::ALIAS, FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY) ? : []);
        $model->setAttribute(ModelAttributes::SORT, filter_input(INPUT_GET, UserInterface::SORT, FILTER_SANITIZE_STRING) ? : null);
        $model->setAttribute(ModelAttributes::PAGE, filter_input(INPUT_GET, UserInterface::PAGE, FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY) ? : []);

        $model->setAttribute(ModelAttributes::_GET, $this->buildInternalGet($model));
    }

    protected function buildInternalGet(Model $model)
    {
        return [
            UserInterface::FIELDS => $model->getAttributeObject(ModelAttributes::FIELDS),
            UserInterface::FILTER => $model->getAttributeObject(ModelAttributes::FILTER),
            UserInterface::SORT => $model->getAttributeObject(ModelAttributes::SORT),
            UserInterface::PAGE => $model->getAttributeObject(ModelAttributes::PAGE),
            UserInterface::ALIAS => $model->getAttributeObject(ModelAttributes::ALIAS),
        ];
    }
}
