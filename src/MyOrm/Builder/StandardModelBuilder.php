<?php namespace CTIMT\MyOrm\Builder;

use CTIMT\MyOrm\Adapter\Alias;
use CTIMT\MyOrm\Adapter\ClearId;
use CTIMT\MyOrm\Adapter\DefaultValue;
use CTIMT\MyOrm\Adapter\Fields;
use CTIMT\MyOrm\Adapter\Filter;
use CTIMT\MyOrm\Adapter\Pagination;
use CTIMT\MyOrm\Adapter\Query;
use CTIMT\MyOrm\Adapter\Required;
use CTIMT\MyOrm\Adapter\Select;
use CTIMT\MyOrm\Adapter\Sort;
use CTIMT\MyOrm\Adapter\StaticValue;
use CTIMT\MyOrm\Entity\EntityInterface;
use CTIMT\MyOrm\Enum\ModelActions;
use CTIMT\MyOrm\Enum\ModelExecutionPriority;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Visitor\Command\ValidateData;
use CTIMT\MyOrm\Visitor\Command\ValidFieldsFilter;
use CTIMT\MyOrm\Visitor\Content\Create;
use CTIMT\MyOrm\Visitor\Content\Delete;
use CTIMT\MyOrm\Visitor\Content\Fetch;
use CTIMT\MyOrm\Visitor\Content\FetchAllFull;
use CTIMT\MyOrm\Visitor\Content\Update;
use CTIMT\MyOrm\Visitor\DataType\Boolean;
use CTIMT\MyOrm\Visitor\DataType\Date;
use CTIMT\MyOrm\Visitor\DataType\Numeric;
use CTIMT\MyOrm\Visitor\DataType\String;
use CTIMT\MyOrm\Visitor\Layout\Collection;
use CTIMT\MyOrm\Visitor\Layout\Entity;
use CTIMT\MyOrm\Visitor\Setup\Encoding;
use CTIMT\MyOrm\Visitor\Setup\TimeZone;
use CTIMT\MyOrm\Visitor\Setup\TimeZoneDb;
use CTIMT\MyOrm\Visitor\Setup\UserInput;
use PDO;

/**
 * Description of ModelBuilder
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class StandardModelBuilder implements ModelBuilderInterface
{

    private $model;

    public function createModel(EntityInterface $entity, \PDO $pdo)
    {
        $this->model = new Model($entity, new Query($pdo));
        return $this;
    }

    public function setup($timeZone = null, $encodingProgram = 'UTF8', $encodingDb = 'utf8mb4')
    {
        $this->getModel()->getQuery()->getAdapter()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->getModel()
            ->accept(new TimeZone($timeZone))
            ->accept(new TimeZoneDb())
            ->accept(new Encoding($encodingProgram, $encodingDb))
            ->accept(new UserInput());
        return $this;
    }

    public function addDataTypeValidations()
    {
        $this->getModel()
            ->accept(new Alias())
            ->accept(new ClearId())
            ->accept(new DefaultValue())
            ->accept(new StaticValue())
            ->accept(new ValidFieldsFilter())
            ->accept(new Required())
            ->accept(new String())
            ->accept(new Date())
            ->accept(new Boolean())
            ->accept(new Numeric())
            ->getActions()
            ->add(ModelActions::CREATE, new ValidateData(), ModelExecutionPriority::PRIOR_TO_ACTION)
            ->add(ModelActions::UPDATE, new ValidateData(), ModelExecutionPriority::PRIOR_TO_ACTION);
        return $this;
    }

    public function addPersistanceActions()
    {
        $this->getModel()->getActions()
            ->add(ModelActions::CREATE, new Create(), ModelExecutionPriority::ACTION)
            ->add(ModelActions::UPDATE, new Update(), ModelExecutionPriority::ACTION)
            ->add(ModelActions::DELETE, new Delete(), ModelExecutionPriority::ACTION);
        $this->addFetch();
        $this->getModel()
            ->accept(new Entity())
            ->accept(new Collection());
        return $this;
    }

    protected function addFetch()
    {
        $this->getModel()->getActions()
            ->add(ModelActions::FETCH, new Fetch(new Select(), [
                new Fields(),
                New Alias()
                ]), ModelExecutionPriority::ACTION)
            ->add(ModelActions::FETCH_ALL, new FetchAllFull(new Select(), [
                new Fields(),
                new Sort(),
                new Filter(),
                new Pagination(),
                New Alias()
                ]), ModelExecutionPriority::ACTION)
        ;
    }

    /**
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }
}
