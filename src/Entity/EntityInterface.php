<?php

namespace CTIMT\MyOrm\Entity;

/**
 * Description of EntityInterface
 *
 * @author David
 */
interface EntityInterface {
    public function getName();
    public function getIdField();
    public function getTable();
    public function getAllFields();
}
