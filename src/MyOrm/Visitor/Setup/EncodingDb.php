<?php namespace CTIMT\MyOrm\Visitor\Setup;

use CTIMT\MyOrm\Connection\ConnectionVisitorInterface;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use PDO;

/**
 * Description of EndcodingDb
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class EncodingDb implements ModelVisitorInterface, ConnectionVisitorInterface
{

    private $encoding;

    public function __construct($encoding = 'utf8mb4')
    {
        $this->setEncoding($encoding);
    }

    public function visitModel(Model $model)
    {
        $this->applyEncoding($model->getQuery()->getAdapter());
    }
    
    public function visitConnection(PDO $pdo)
    {
        $this->applyEncoding($pdo);
    }
    
    protected function applyEncoding(PDO $pdo){
        $pdo->exec('SET NAMES ' . $this->getEncoding());
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
