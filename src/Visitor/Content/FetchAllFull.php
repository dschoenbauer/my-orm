<?php

namespace CTIMT\MyOrm\Visitor\Content;

use CTIMT\MyOrm\Adapter\Fields;
use CTIMT\MyOrm\Adapter\Filter;
use CTIMT\MyOrm\Adapter\PaginatedReponse;
use CTIMT\MyOrm\Adapter\Select;
use CTIMT\MyOrm\Adapter\Sort;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use PDO;

/**
 * Description of FetchAllFull
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class FetchAllFull implements ModelVisitorInterface {

    public function visitModel(Model $model) {
        $select = new Select();
        $paginator = new PaginatedReponse();
        $orderBy = new Sort();
        $filter = new Filter();
        $fields = new Fields();
        $select
                ->setFields($model->getEntity()->getAllFields())
                ->addFrom($model->getEntity()->getTable());
        $model->accept($paginator)->accept($orderBy)->accept($filter)->accept($fields);
        $select->accept($paginator)->accept($orderBy)->accept($filter)->accept($fields);

        $stmt = $model->getQuery()->getAdapter()->prepare($select->getSql());
        if($select->getWhere() && $select->getWhere()->getParameters()){
            $stmt->execute($select->getWhere()->getParameters());
        }else{
            $stmt->execute();
        }
        $model->setData($stmt->fetchAll(PDO::FETCH_ASSOC));
        $model->notify(ModelEvents::PRIMARY_DATA_PULLED);
    }
}
