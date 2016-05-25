<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Enum\ErrorMessages;
use CTIMT\MyOrm\Exception\Adapter\NonComittableException;
use PDO;

/**
 * Description of Query
 *
 * @author David
 */
class Query
{

    use ArrayToKeyTrait;

    private $_adapter;

    public function __construct(PDO $adapter)
    {
        $this->setAdapter($adapter);
    }

    /**
     * @return PDO Description
     */
    function getAdapter()
    {
        return $this->_adapter;
    }

    function setAdapter(PDO $adapter)
    {
        $this->_adapter = $adapter;
        return $this;
    }

    /**
     * 
     * @param string $table name of a table
     * @param array $fieldValueArray associative array that has keys that are 
     *          fields and values are values of the db
     * @return mixed last insert id
     * @throws NonComittableException
     */
    public function insert($table, array $fieldValueArray)
    {
        try {
            $sqlTemplate = "INSERT INTO %s (%s) VALUES (:%s)";
            $sql = sprintf($sqlTemplate, $table, implode(', ', array_keys($fieldValueArray)), implode(', :', array_keys($fieldValueArray)));
            $stmt = $this->getAdapter()->prepare($sql);
            $stmt->execute($fieldValueArray);
            return $this->getAdapter()->lastInsertId();
        } catch (\Exception $exc) {
            throw new NonComittableException(ErrorMessages::QUERY_INSERT_EXCEPTION, 0, $exc);
        }
    }

    /**
     * 
     * @param type $table name of a table
     * @param array $fieldValueArray
     * @param WhereStatement $whereStatement associative array that has keys that are 
     *          fields and values are values of the db
     * @return boolean true on success
     * @throws NonComittableException
     */
    public function update($table, array $fieldValueArray, WhereStatement $whereStatement = null)
    {
        try {
            $sets = $this->arrayToKeyedArray($fieldValueArray);
            if ($whereStatement instanceof WhereStatement) {
                $where = sprintf("WHERE %s", $whereStatement->getStatment());
                $fieldValueArray = array_merge($fieldValueArray, $whereStatement->getParameters());
            }
            $sqlTemplate = "UPDATE %s SET %s %s";
            $sql = sprintf($sqlTemplate, $table, implode(',', $sets), $where);
            return $this->getAdapter()->prepare($sql)->execute($fieldValueArray);
        } catch (\Exception $exc) {
            throw new NonComittableException(ErrorMessages::QUERY_UPDATE_EXCEPTION, 0, $exc);
        }
    }

    /**
     * 
     * @param type $table name of a table
     * @param WhereStatement $whereStatement associative array that has keys that are 
     *          fields and values are values of the db
     * @return boolean true on success
     * @throws NonComittableException
     */
    public function delete($table, WhereStatement $whereStatement = null)
    {
        try {
            $sqlTemplate = 'DELETE %1$s.* FROM %1$s';
            $sql = sprintf($sqlTemplate, $table);
            if ($whereStatement instanceof WhereStatement) {
                $where = sprintf(" WHERE %s", $whereStatement->getStatment());
                $parameters = $whereStatement->getParameters();
                return $this->getAdapter()->prepare($sql . $where)->execute($parameters);
            }
            return $this->getAdapter()->prepare($sql)->execute();
        } catch (\Exception $exc) {
            throw new NonComittableException(ErrorMessages::QUERY_UPDATE_EXCEPTION, 0, $exc);
        }
    }

    public function select($table, array $fields, WhereStatement $whereStatement = null, $fetchFlat = false, $fetchStyle = \PDO::FETCH_ASSOC, $defaultValue = [])
    {
        $sqlTempalate = "SELECT %s FROM %s";
        $sql = sprintf($sqlTempalate, implode(',', $fields), $table);
        if ($whereStatement instanceof WhereStatement) {
            $where = sprintf(" WHERE %s", $whereStatement->getStatment());
            $stmt = $this->getAdapter()->prepare($sql . $where);
            $stmt->execute($whereStatement->getParameters());
        } else {
            $stmt = $this->getAdapter()->prepare($sql);
            $stmt->execute();
        }

        if ($fetchFlat) {
            return $stmt->fetch($fetchStyle) ? : $defaultValue;
        }
        return $stmt->fetchAll($fetchStyle) ? : $defaultValue;
    }
}
