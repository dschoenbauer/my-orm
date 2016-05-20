<?php

namespace CTIMT\MyOrm\Entity;

/**
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
interface IsSortableInterface {
    public function getSortFields();
    public function getDefaultSortField();
    public function getDefaultSortDirection();
}
