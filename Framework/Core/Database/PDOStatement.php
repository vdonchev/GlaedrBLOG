<?php


namespace Framework\Core\Database;


class PDOStatement implements DatabaseStatementInterface
{
    private $statement;

    public function __construct(\PDOStatement $statement)
    {
        $this->statement = $statement;
    }

    public function execute(array $params = [])
    {
        return $this->statement->execute($params);
    }

    public function fetchRow()
    {
        return $this->statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function fetchAll()
    {
        while ($row = $this->fetchRow()) {
            yield $row;
        }
    }

    public function fetchObj($className = \stdClass::class)
    {
        return $this->statement->fetchObject($className);
    }

    public function __destruct()
    {
        $this->statement = null;
    }
}