<?php namespace CTIMT\MyOrm\DataProvider;

use CTIMT\MyOrm\Exception\DataProvider\MissingParameter;
use PDO;

/**
 * Description of AbstractDataProvider
 *
 * @author David
 */
abstract class AbstractDataProvider implements DataProviderInterface
{

    private $_parameters = null;
    private $_pdo;
    private $_fetchStyle;
    private $_defaultValue = [];
    private $_fetchFlat = false;

    public function __construct(PDO $pdo, array $parameters)
    {
        $this->setPdo($pdo)->validateParameters($parameters);
    }

    abstract protected function validateParameters($parameters);

    public function getData()
    {
        $stmts = $this->getPdo()->prepare($this->getSql());
        $stmts->execute($this->getParameters());
        if ($this->getFetchFlat()) {
            return $stmts->fetch($this->getFetchStyle()) ? : $this->getDefaultValue();
        }
        return $stmts->fetchAll($this->getFetchStyle()) ? : $this->getDefaultValue();
    }

    public function getParameters()
    {
        return $this->_parameters;
    }

    protected function setParameters($parameters)
    {
        $this->_parameters = $parameters;
        return $this;
    }

    /**
     * 
     * @return PDO
     */
    function getPdo()
    {
        return $this->_pdo;
    }

    function setPdo(PDO $pdo)
    {
        $this->_pdo = $pdo;
        return $this;
    }

    function getFetchStyle()
    {
        return $this->_fetchStyle;
    }

    function setFetchStyle($fetchStyle)
    {
        $this->_fetchStyle = $fetchStyle;
        return $this;
    }

    function getDefaultValue()
    {
        return $this->_defaultValue;
    }

    function setDefaultValue($defaultValue)
    {
        $this->_defaultValue = $defaultValue;
        return $this;
    }

    function getFetchFlat()
    {
        return $this->_fetchFlat;
    }

    function setFetchFlat($fetchFlat = true)
    {
        $this->_fetchFlat = $fetchFlat;
        return $this;
    }

    /**
     * provides consistancy and allows for validation of parameter fields.
     * @param type $field
     * @param type $parameters
     * @return boolean true for no errors
     * @throws MissingParameter
     */
    protected function validateExistance($field, $parameters)
    {
        if (is_array($field) && count(array_intersect($field, array_keys($parameters))) == 0) {
            throw new MissingParameter($field);
        } elseif (!is_array($field) && !array_key_exists($field, $parameters)) {
            throw new MissingParameter($field);
        }
        return true;
    }

    /**
     * Returns the first field in a list of fields. Helpful for multi use data providers
     * @param array $fields an array of fields to check for existance these are thought of as an or and NOT an and.
     * @param array $parameters the parameters provided by the client on of the field values must be a key in there.
     * @return string the first field in the list of field
     */
    protected function getField(array $fields, $parameters)
    {
        $this->validateExistance($fields, $parameters);
        $matchedFields = array_intersect($fields, array_keys($parameters));
        return reset($matchedFields);
    }
}
