<?php

/*
 * Copyright 2014 Coe-Truman International.
 *
 */

namespace CTIMT\MyOrm\Enum;

/**
 * @author David Schoenbauer <dschoenbauer@coetruman.com>
 * @since 1.0
 */
class PaginatedReponseKeys {
    const PARAMETER_PAGE = 'page';
    
    const KEY_PAGE_CURRENT = 'number';
    const KEY_PAGE_COUNT = 'count';
    const KEY_PAGE_SIZE = "size";
    const KEY_TOTAL_ITEMS = "total";
    
    const KEY_PREVIOUS = "prev";
    const KEY_CURRENT = 'self';
    const KEY_NEXT = "next";
}
