<?php

namespace Classes;

require __DIR__.'/../vendor/autoload.php';

use PDO;

class Database {

    const DB_HOST = 'localhost';
    const DB_NAME = 'api_teste';
    const DB_USER = 'root';
    const DB_PASS = '';

    private $table;
    private $connection;

    public function __construct ($table = null) {
        $this->table = $table;
        $this->setConnection();
    }

    public function setConnection() {
        try {
            $this->connection = new PDO("mysql:host=".self::DB_HOST.";dbname=".self::DB_NAME, self::DB_USER, self::DB_PASS, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\Throwable $e) {
            var_dump($e->getMessage());
        }
    }

    public function execute($query, $params = []) {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (\Throwable $e) {
            var_dump($e->getMessage());
        }
    }

    public function insert($values) {
        $fields = array_keys($values);
        $binds = array_pad([], count($fields), '?');

        $query = "INSERT INTO {$this->table} (".implode(",", $fields).") VALUES (".implode(", ", $binds).")";

        $this->execute($query, array_values($values));

        return $this->connection->lastInsertId();
    }

    public function update($values, $id) {
        $fields = array_keys($values);

        $query = "UPDATE {$this->table} SET ".implode(" = ?, ", $fields)." = ? WHERE id = ".$id;

        return $this->execute($query, array_values($values));
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = {$id}";

        return $this->execute($query);
    }

    public function select($where = null, $order = null, $limit = null, $fields = '*') {
        $where = !empty($where) ? ' WHERE '.$where : '';
        $order = !empty($order) ? ' ORDER BY '.$order : '';
        $limit = !empty($order) ? ' LIMIT '.$limit : '';

        $query = "SELECT {$fields} FROM {$this->table} {$where} {$order} {$limit}";

        return $this->execute($query);
    }
}
