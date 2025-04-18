<?php

namespace App\Dao;

use App\Models\CPVC;
use App\Services\database_connection;
use App\Interface\DAOInterface;

class CPVC_DAO implements DAOInterface
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CPVC_DAO();
        }
        return self::$instance;
    }

    public function getAll(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM CPVC");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createCPVCModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    public function search($value, $columns): array
    {
        $list = [];
        $conditions = implode(" OR ", array_map(fn($col) => "$col LIKE ?", $columns));
        $query = "SELECT * FROM CPVC WHERE $conditions";
        $params = array_fill(0, count($columns), "%$value%");
        $rs = database_connection::executeQuery($query, ...$params);
        
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createCPVCModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    
    public function getById($id)
    {
        $query = "SELECT * FROM CPVC WHERE IDTINH = ?";
        $result = database_connection::executeQuery($query, $id);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $this->createCPVCModel($row);
        }
        return null;
    }

    public function insert($model): int
    {
        $query = "INSERT INTO CPVC (IDTINH, IDVC, CHIPHIVC) VALUES (?, ?, ?)";
        $args = [$model->getIDTINH(), $model->getIDVC(), $model->getCHIPHIVC()];
        return database_connection::executeQuery($query, ...$args);
    }

    public function update($model): int
    {
        $query = "UPDATE CPVC SET IDVC = ?, CHIPHIVC = ? WHERE IDTINH = ?";
        $args = [$model->getIDVC(), $model->getCHIPHIVC(), $model->getIDTINH()];
        return database_connection::executeQuery($query, ...$args);
    }

    public function delete($id): int
    {
        $query = "DELETE FROM CPVC WHERE IDTINH = ?";
        return database_connection::executeQuery($query, $id);
    }

    private function createCPVCModel($row): CPVC
    {
        return new CPVC(
            $row['IDTINH'],
            $row['IDVC'],
            $row['CHIPHIVC']
        );
    }
    public function readDatabase(): array
    {
        return $this->getAll();
    }
}