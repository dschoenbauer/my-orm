<?php namespace CTIMT\MyOrm\Visitor\Setup;

use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;

/**
 * Description of Utf8
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Encoding implements ModelVisitorInterface
{

    private $encoding;

    public function __construct($encoding = 'UTF8')
    {
        $this->setEncoding($encoding);
    }

    public function visitModel(Model $model)
    {
        mb_internal_encoding($this->getEncoding());
        ini_set("default_charset", $this->getEncoding());

        mb_http_output($this->getEncoding());
        mb_http_input($this->getEncoding());
        mb_regex_encoding($this->getEncoding());
    }

    public function getEncoding()
    {
        return $this->encoding;
    }

    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
        return $this;
    }
}
