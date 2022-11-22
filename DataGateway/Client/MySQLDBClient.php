<?php

namespace App\DataGateway\Client;

class MySQLDBClient
{
    public function __construct(
        private ?string $host = null,
        private ?string $dbname = null,
        private ?string $user = null,
        private ?string $password = null
    ) {
    }

    /**
     * Setup connection parameters
     * @param $host
     * @param $dbname
     * @param $user
     * @param $password
     * @return void
     */
    public function setConnectionParams($host, $dbname, $user, $password)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;
    }

    public function getConnection(): \PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";
        return new \PDO($dsn, $this->user, $this->password);
    }
}
