<?php

namespace App\Dao;

use App\Interface\DAOInterface;
use App\Services\database_connection;

class CTSP_DAO implements DAOInterface {
    public function readDatabase(): array {
        return [];
    }

    public function insert($e): int {
        $sql = "INSERT INTO CTSP (idSP, soSeri) 
        VALUES (?, ?)";
        $args = [$e->getIdSP(), $e->getSoSeri()];
        return database_connection::executeQuery($sql, ...$args);
    }

    public function update($e): int {
        return 0;
    }

    public function delete(int $id): int {
        return 0;
    }

    public function search(string $condition, array $columnNames): array {
        return [];
    }
}