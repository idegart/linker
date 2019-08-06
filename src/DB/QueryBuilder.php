<?php

namespace Idegart\Linker\DB;

use PDO;

class QueryBuilder
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function query($query, $parameters = [], $select = false)
    {
        $statement = $this->pdo->prepare($query);

        $result = $statement->execute($parameters);

        return $select ? $statement->fetchAll(PDO::FETCH_ASSOC) : $result;
    }

    public function getLastId() : string
    {
        return $this->pdo->lastInsertId();
    }

}
