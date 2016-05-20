<?php
namespace CTIMT\MyOrm\Model;

use CTIMT\MyOrm\Adapter\Query;
use CTIMT\MyOrm\Entity\AbstractEntity;
use CTIMT\MyOrm\Visitor\Composite\AddDataTypeValidations;
use CTIMT\MyOrm\Visitor\Composite\AddPersistanceActionsToModel;
use CTIMT\MyOrm\Visitor\Composite\Setup;
use PDO;

/**
 * Description of ModelFactory
 *
 * @author David
 */
class ModelFactory {

    private $_model;

    public function __construct(AbstractEntity $entity, PDO $adapter) {
        $this->setModel(new Model($entity, New Query($adapter)));
    }

    /**
     * @return Model
     */
    public function getStandardModel() {
        return $this->getModel()
                ->accept(New Setup())
                ->accept(new AddDataTypeValidations())
                ->accept(new AddPersistanceActionsToModel());
    }

    /**
     * @return Model
     */
    public function getModel() {
        return $this->_model;
    }

    public function setModel($model) {
        $this->_model = $model;
        return $this;
    }
}
