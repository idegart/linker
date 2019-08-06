<?php

namespace Idegart\Linker;

use Exception;
use Idegart\Linker\DB\Connection;
use Idegart\Linker\DB\QueryBuilder;
use PDOException;

class Linker implements LinkerBaseInterface
{
    private $table = 'links';

    public $id;

    public $realLink;

    public $shortLink;

    /** @var QueryBuilder */
    private $connection;

    public function __construct()
    {
        $configs = require 'config.php';

        $this->makeConnection($configs);
    }

    /**
     * @param string $link
     * @return string
     * @throws Exception
     */
    public function storeLink(string $link): string
    {
        if (!filter_var($link, FILTER_VALIDATE_URL)) {
            throw new Exception('Not valid URL');
        }
        $this->realLink = $link;

        $linkExists = $this->getByLink($link);

        if ($linkExists instanceof Linker) {
            return $linkExists->shortLink;
        }

        $tries = 0;

        do {
            $tries++;

            $this->shortLink = $this->generateRandomString();

            $linkExists = $this->getByLink($this->shortLink, false);

            if ($linkExists == null) {
                $this->store();
            }
        } while (!$this->id && $tries < 10);

        if ($tries >= 10) {
            throw new Exception('Tries exceeded: ' . $tries);
        }

        return $this->shortLink;
    }

    public function getRealLink(string $shortLink): string
    {
        $this->getByLink($shortLink, false);

        return $this->realLink;
    }

    public function getByLink(string $link, $isReal = true) : ?Linker
    {
        $sql = "SELECT id, real_link, short_link
                FROM {$this->table}
                WHERE " . ($isReal ? 'real_link' : 'short_link') . " = :link";

        $result = $this->connection->query($sql, [
            'link' => $link
        ], true);

        if (!$result || !count($result)) {
            return null;
        }

        $linkerResult = $result[0];

        $this->id = $linkerResult['id'];
        $this->realLink = $linkerResult['real_link'];
        $this->shortLink = $linkerResult['short_link'];

        return $this;
    }

    private function makeConnection($dbConfig)
    {
        if ($this->connection) {
            return $this->connection;
        }

        $connection = new Connection(
            $dbConfig['connection'], $dbConfig['name'],
            $dbConfig['user'], $dbConfig['password'],
            $dbConfig['options']
        );

        $this->connection = new QueryBuilder($connection->make());
    }

    private function store() : bool
    {
        $sql = "INSERT INTO {$this->table} (real_link, short_link) VALUES (:real_link, :short_link)";

        try {
            $this->connection->query($sql, [
                'real_link' => $this->realLink,
                'short_link' => $this->shortLink,
            ]);

            $this->id = $this->connection->getLastId();

            return true;
        } catch (PDOException $exception){
            return false;
        }
    }

    function generateRandomString($length = 10) {
        $chars = 'abcdefghijklmnopqrstuvwxyz';
        $upChars = mb_strtoupper($chars);
        $numbers = '0123456789';

        $characters = $chars . $upChars . $numbers;

        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
