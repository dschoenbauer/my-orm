<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CTIMT\MyOrm\Model;

/**
 * Description of ActionCollection
 *
 * @author David
 */
class ActionCollection {

    const DATA = 'data';
    const PRIORITY = 'priority';
    const INSERTED = 'inserted';

    private $_insertIndex = 0;
    private $_actions = [];

    /**
     * 
     * @param type $modelAction
     * @param \CTIMT\MyOrm\Model\ModelVisitorInterface $modelVisitor
     * @param type $priority smaller the number earlier the execution. Numbers 
     * below zero are before action numbers after zero follow the action.
     * @return \CTIMT\MyOrm\Model\ActionCollection
     */
    public function add($modelAction, ModelVisitorInterface $modelVisitor, $priority) {

        $this->_actions[$modelAction][] = [
            self::PRIORITY => (int) $priority,
            self::INSERTED => $this->_insertIndex++,
            self::DATA => $modelVisitor,
        ];
        return $this;
    }

    public function run($modelAction, Model $model) {
        /* Indredibly mean but handles late additions to the queue */
        for ($i = 0; $i < count($this->extractQueue($modelAction)); $i++) {
            $model->accept($this->extractQueue($modelAction)[$i]);
        }
    }

    private function extractQueue($queueName) {
        if (!array_key_exists($queueName, $this->_actions)) {
            return [];
        }
        $queue = $this->_actions[$queueName];
        foreach ($queue as $key => $row) {
            $sort1[$key] = $row[self::PRIORITY];
            $sort2[$key] = $row[self::INSERTED];
        }
        if (!array_multisort($sort1, SORT_ASC, $sort2, SORT_ASC, $queue)) {
            return new \LogicException('Error in sort:' . __CLASS__);
        }
        return array_column($queue, self::DATA);
    }

}
