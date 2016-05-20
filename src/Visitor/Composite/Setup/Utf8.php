<?php

namespace CTIMT\MyOrm\Visitor\Composite\Setup;

use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of Utf8
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Utf8 implements ModelVisitorInterface {

    public function visitModel(Model $model) {
        ini_set("default_charset", "UTF-8");
        mb_internal_encoding("UTF-8");
        iconv_set_encoding("internal_encoding", "UTF-8");
        iconv_set_encoding("output_encoding", "UTF-8");

        $model->getQuery()->getAdapter()->exec('SET NAMES utf8mb4');
    }

}
