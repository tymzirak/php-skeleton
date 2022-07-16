<?php

namespace App\Core;

class Database
{
    private string $host = "localhost";
    private string $dbName = "skeleton";
    private string $username = "username";
    private string $password = "password";
    private string $dbms = "mysql";

    private \PDO $connection;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        try {
            $this->connection = new \PDO(
                $this->dbms.":host=".$this->host.";dbname=".$this->dbName,
                $this->username,
                $this->password
            );
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function query(string $query, array $params=[])
    {
        $sth = $this->connection->prepare($query);
        $sth->execute($params);

        if (preg_match("/^SELECT\b/i", $query)) {
            return $sth->fetchAll();
        }
    }

    public function recordAdd(string $table, array $attrs)
    {
        $columnsStr = "";
        $columnsTemp = "";
        foreach ($attrs as $column => $value) {
        	$columnsStr .= ",$column";
            $columnsTemp .= ",?";
        	$values[] = $value;
        }
        $columnsStr = trim($columnsStr, ",");
        $columnsTemp = trim($columnsTemp, ",");

        $query = "INSERT INTO $table ($columnsStr) VALUES ($columnsTemp);";
        $this->query($query, $values);
    }

    public function recordsDelete(string $table, string $idColumn, $idValue)
    {
        $query = "DELETE FROM $table WHERE $idColumn = ?;";
        $this->query($query, [$idValue]);
    }

    public function recordsEdit(string $table, string $idColumn, $idValue, array $attrs)
    {
        $columnsTemp = "";
        foreach ($attrs as $column => $value) {
        	$columnsTemp .= ",$column=?";
            $values[] = $value;
        }
        $values[] = $idValue;
        $columnsTemp = trim($columnsTemp, ",");

        $query = "UPDATE $table SET $columnsTemp WHERE $idColumn = ?;";
        $this->query($query, $values);
    }

    public function recordsGet(string $table, string $idColumn, $idValue): array
    {
        $query = "SELECT * FROM $table WHERE $idColumn = ?;";

        return $this->query($query, [$idValue]);
    }
}
