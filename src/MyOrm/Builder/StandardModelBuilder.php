<?php namespace CTIMT\MyOrm\Builder;

use CTIMT\MyOrm\Adapter\Alias;
use CTIMT\MyOrm\Adapter\AliasCollectionView;
use CTIMT\MyOrm\Adapter\AliasEntityView;
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
use CTIMT\MyOrm\Adapter\TransactionBegin;
use CTIMT\MyOrm\Adapter\TransactionCommit;
use CTIMT\MyOrm\Adapter\TransactionRollBack;
use CTIMT\MyOrm\Entity\EntityInterface;
use CTIMT\MyOrm\Enum\ModelActions;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Enum\ModelExecutionPriority;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Visitor\Command\UserInput;
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
use PDO;

/**
 * Description of ModelBuilder
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class StandardModelBuilder implements ModelBuilderInterface
{

    private $model;

    public function createModel(EntityInterface $entity, PDO $pdo)
    {
        $this->model = new Model($entity, new Query($pdo));
        return $this;
    }

    public function setup($timeZone = null, $encoding = 'UTF8')
    {
        $this->getModel()
            ->accept(new TimeZone($timeZone))
            ->accept(new Encoding($encoding))
            ->accept(new UserInput());
        return $this;
    }

    public function prepareDataConnection($encoding = 'utf8mb4')
    {
        $this->getModel()
            ->accept(new TransactionBegin([ModelEvents::TRAMSACTION_START]))
            ->accept(new TransactionCommit([ModelEvents::TRAMSACTION_COMPLETE]))
            ->accept(new TransactionRollBack([ModelEvents::ERROR]))
        ;
    }

    public function addDataTypeValidations()
    {
        $valiadteEvents = [ModelEvents::VALIDATE];
        $this->getModel()
            ->accept(new Alias($valiadteEvents))
            ->accept(new ClearId($valiadteEvents))
            ->accept(new DefaultValue($valiadteEvents))
            ->accept(new StaticValue($valiadteEvents))
            ->accept(new ValidFieldsFilter($valiadteEvents))
            ->accept(new Required($valiadteEvents))
            ->accept(new String($valiadteEvents))
            ->accept(new Date($valiadteEvents))
            ->accept(new Boolean($valiadteEvents))
            ->accept(new Numeric($valiadteEvents))
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
                new Fields([ModelEvents::LAYOUT_ENTITY_APPLIED]),
                new AliasEntityView([ModelEvents::LAYOUT_ENTITY_APPLIED]),
                ]), ModelExecutionPriority::ACTION)
            ->add(ModelActions::FETCH_ALL, new FetchAllFull(new Select(), [
                new Fields([ModelEvents::LAYOUT_COLLECTION_APPLIED]),
                new Sort([ModelEvents::LAYOUT_COLLECTION_APPLIED]),
                new Filter([ModelEvents::LAYOUT_COLLECTION_APPLIED]),
                new Pagination(),
                new AliasCollectionView([ModelEvents::LAYOUT_COLLECTION_APPLIED])
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
