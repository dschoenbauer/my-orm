<?php namespace CTIMT\MyOrm\Connection;

/**
 * Description of ConnectionDecorator
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class ConnectionDecorator extends \PDO
{
    private $concretePDO;

    public function __construct(\PDO $concretePDO)
    {
        $this->setConcretePDO($concretePDO);
    }

    public function beginTransaction()
    {
        return $this->getConcretePDO()->beginTransaction();
    }

    public function commit()
    {
        return $this->getConcretePDO()->commit();
    }

    public function errorCode()
    {
        return $this->getConcretePDO()->errorCode();
    }

    public function errorInfo()
    {
        return $this->getConcretePDO()->errorInfo();
    }

    public function exec($statement)
    {
        return $this->getConcretePDO()->exec($statement);
    }

    public function getAttribute($attribute)
    {
        return $this->getConcretePDO()->getAttribute($attribute);
    }

    public static function getAvailableDrivers()
    {
        return $this->getConcretePDO()->getAvailableDrivers();
    }

    public function inTransaction()
    {
        return $this->getConcretePDO()->inTransaction();
    }

    public function lastInsertId($name = null)
    {
        return $this->getConcretePDO()->lastInsertId($name);
    }

    public function prepare($statement, $options = null)
    {
        if($options){
            return $this->getConcretePDO()->prepare($statement, $options);
        }
        return $this->getConcretePDO()->prepare($statement);
    }

    public function query($statement)
    {
        return $this->getConcretePDO()->query($statement);
    }

    public function quote($string, $parameter_type = \PDO::PARAM_STR)
    {
        return $this->getConcretePDO()->quote($string, $parameter_type);
    }

    public function rollBack()
    {
        return $this->getConcretePDO()->rollBack();
    }

    public function setAttribute($attribute, $value)
    {
        return $this->getConcretePDO()->setAttribute($attribute, $value);
    }

    /**
     * @return \PDO
     */
    final public function getConcretePDO()
    {
        return $this->concretePDO;
    }

    final public function setConcretePDO($concretePDO)
    {
        $this->concretePDO = $concretePDO;
        return $this;
    }
    
    public function accept(ConnectionVisitorInterface $visitor){
        $visitor->visitConnection($this);
    }
}
