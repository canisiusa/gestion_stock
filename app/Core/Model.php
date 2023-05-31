<?php

namespace Core\Database;

use PDO;

class Model
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    protected function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    protected function select($table, $where = [], $fields = '*', $orderBy = '')
    {
        $sql = "SELECT $fields FROM $table";

        if (!empty($where)) {
            $whereStr = implode(' AND ', array_map(function ($k) {
                return "$k = :$k";
            }, array_keys($where)));

            $sql .= " WHERE $whereStr";
        }

        if (!empty($orderBy)) {
            $sql .= " ORDER BY $orderBy";
        }

        $stmt = $this->query($sql, $where);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function insert($table, $data)
    {
        $keys = implode(',', array_keys($data));
        $values = ':' . implode(',:', array_keys($data));

        $sql = "INSERT INTO $table ($keys) VALUES ($values)";

        $this->query($sql, $data);

        return $this->pdo->lastInsertId();
    }
}
