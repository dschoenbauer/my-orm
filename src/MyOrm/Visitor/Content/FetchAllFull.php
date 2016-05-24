<?php

namespace CTIMT\MyOrm\Visitor\Content;

use CTIMT\MyOrm\Adapter\Select;
use CTIMT\MyOrm\Adapter\SelectVisitorInterface;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Enum\Settings;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of FetchAllFull
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class FetchAllFull implements ModelVisitorInterface {

    const PDO_FETCH = 196610;

    private $_select;
    private $_visitors = [];
    private $_fetchFlat = [];
    private $_fetchStyle = self::PDO_FETCH;

    public function __construct(Select $select, array $visitors = []) {
        $this->setSelect($select)->setVisitors($visitors);
    }

    public function visitModel(Model $model) {
        $this->getSelect()
                ->setFields($model->getEntity()->getAllFields())
                ->addFrom($model->getEntity()->getTable());
        $this->applyVisitors($model, $this->getSelect(), $this->getVisitors());
        $this->runTemplate($model);
        $this->getSelect()->setFields(array_merge([$model->getEntity()->getIdField() . ' ' . Settings::ROW_ID], $this->getSelect()->getFields()));
        $stmt = $model->getQuery()->getAdapter()->prepare($this->getSelect()->getSql());
        if ($this->getSelect()->getWhere() && $this->getSelect()->getWhere()->getParameters()) {
            $stmt->execute($this->getSelect()->getWhere()->getParameters());
        } else {
            $stmt->execute();
        }
        if ($this->getFetchFlat()) {
            $data = $stmt->fetch($this->getFetchStyle());
            $model->setData([$model->getId() => $data]);
        } else {
            $model->setData($stmt->fetchAll($this->getFetchStyle()));
        }
        $model->notify(ModelEvents::PRIMARY_DATA_PULLED);
    }

    private function applyVisitors(Model $model, Select $select, $visitors) {
        foreach ($visitors as $visitor) {
            if ($visitor instanceof ModelVisitorInterface) {
                $model->accept($visitor);
            }
            if ($visitor instanceof SelectVisitorInterface) {
                $select->accept($visitor);
            }
        }
        return $this;
    }

    /**
     * @return Select
     */
    public function getSelect() {
        return $this->_select;
    }

    public function setSelect($select) {
        $this->_select = $select;
        return $this;
    }

    public function getVisitors() {
        return $this->_visitors;
    }

    public function setVisitors(array $visitors = []) {
        $this->_visitors = $visitors;
        return $this;
    }

    protected function runTemplate(Model $model) {
        
    }

    public function getFetchFlat() {
        return $this->_fetchFlat;
    }

    public function setFetchFlat($fetchFlat = true) {
        $this->_fetchFlat = $fetchFlat;
        return $this;
    }

    public function getFetchStyle() {
        return $this->_fetchStyle;
    }

    public function setFetchStyle($fetchStyle) {
        $this->_fetchStyle = $fetchStyle;
        return $this;
    }

}
