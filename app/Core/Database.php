<?php

namespace App\Core;

class Database {
    private $host      = "localhost";
    private $dbName    = "skeleton";
    private $username  = "username";
    private $password  = "password";

    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() : void {
        try {
            $this->conn = new \PDO(
                "mysql:host=".$this->host.";dbname=".$this->dbName,
                $this->username,
                $this->password
            );
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function query(string $query, array $params=[]) {
        $sth = $this->conn->prepare($query);
        $sth->execute($params);

        if (preg_match("/^SELECT\b/i", $query)) return $sth->fetchAll();
    }

    public function recordAdd(string $table, array $attrs) : void {
        $columnsStr = ""; $columnsTemp = "";
        foreach ($attrs as $column => $value) {
        	$columnsStr .= ",$column"; $columnsTemp .= ",?";
        	$values[] = $value;
        }
        $columnsStr = trim($columnsStr, ",");
        $columnsTemp = trim($columnsTemp, ",");

        $query = "INSERT INTO $table ($columnsStr) VALUES ($columnsTemp);";
        $this->query($query, $values);
    }

    public function recordsDelete(string $table, string $idColumn, $idValue) : void {
        $query = "DELETE FROM $table WHERE $idColumn = ?;";
        $this->query($query, [$idValue]);
    }

    public function recordsEdit(string $table, string $idColumn, $idValue, array $attrs) : void {
        $columnsTemp = "";
        foreach ($attrs as $column => $value) {
        	$columnsTemp .= ",$column=?"; $values[] = $value;
        }
        $values[] = $idValue;
        $columnsTemp = trim($columnsTemp, ",");

        $query = "UPDATE $table SET $columnsTemp WHERE $idColumn = ?;";
        $this->query($query, $values);
    }

    public function recordsGet(string $table, string $idColumn, $idValue) : array {
        $query = "SELECT * FROM $table WHERE $idColumn = ?;";
        return $this->query($query, [$idValue]);
    }
}
