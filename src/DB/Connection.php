<?php

namespace Idegart\Linker\DB;

use PDO;
use PDOException;

class Connection
{
    private $connection;

    private $name;

    private $user;

    private $password;

    private $options;

    public function __construct($connection, $name, $user, $password, $options)
    {
        $this->connection = $connection;

        $this->name = $name;

        $this->user = $user;

        $this->password = $password;

        $this->options = $options;
    }

    public function make() : PDO
    {
        try {
            return new PDO(
                "{$this->connection};dbname={$this->name}",
                $this->user,
                $this->password,
                $this->options
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
