<?php

namespace CTIMT\MyOrm\Visitor\Setup;

use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of Utf8
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Encoding implements ModelVisitorInterface {

    private $_encodingProgram;
    private $_encodingDb;

    public function __construct($encodingProgram = 'UTF8', $encodingDb = 'utf8mb4') {
        $this->setEncodingDb($encodingDb)->setEncodingProgram($encodingProgram);
    }

    public function visitModel(Model $model) {
        mb_internal_encoding($this->getEncodingProgram());
        ini_set("default_charset", $this->getEncodingProgram());
        iconv_set_encoding("output_encoding", $this->getEncodingProgram());
        iconv_set_encoding("internal_encoding", $this->getEncodingProgram());

        mb_http_output($this->getEncodingProgram()); 
        mb_http_input($this->getEncodingProgram()); 
        mb_regex_encoding($this->getEncodingProgram()); 
        
        
        $model->getQuery()->getAdapter()->exec('SET NAMES ' . $this->getEncodingDb());
    }

    public function getEncodingProgram() {
        return $this->_encodingProgram;
    }

    public function getEncodingDb() {
        return $this->_encodingDb;
    }

    public function setEncodingProgram($encodingProgram) {
        $this->_encodingProgram = $encodingProgram;
        return $this;
    }

    public function setEncodingDb($encodingDb) {
        $this->_encodingDb = $encodingDb;
        return $this;
    }

}
