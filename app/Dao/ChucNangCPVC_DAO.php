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
    public function search(string $condition, array $columnNames): array
    {
        $list = [];
        $conditions = implode(" OR ", array_map(fn($col) => "$col LIKE ?", $columnNames));
        $query = "SELECT * FROM CPVC WHERE $conditions";
        $params = array_fill(0, count($columnNames), "%$condition%");
        $rs = database_connection::executeQuery($query, ...$params);
        
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createCPVCModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    
    public function getById($id)
    {
        $query = "SELECT * FROM CPVC WHERE idTinh = ?";
        $result = database_connection::executeQuery($query, $id);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $this->createCPVCModel($row);
        }
        return null;
    }

    public function insert($model): int
    {
        $query = "INSERT INTO CPVC (idTinh, idVC, chiPhiVC) VALUES (?, ?, ?)";
        $args = [$model->getIdTinh(), $model->getIdVC(), $model->getChiPhiVC()];
        return database_connection::executeQuery($query, ...$args);
    }

    public function update($model): int
    {
        $query = "UPDATE CPVC SET idVC = ?, chiPhiVC = ? WHERE idTinh = ?";
        $args = [$model->getIdVC(), $model->getChiPhiVC(), $model->getIdTinh()];
        return database_connection::executeQuery($query, ...$args);
    }

    public function delete($id): int
    {
        $query = "DELETE FROM CPVC WHERE idTinh = ?";
        return database_connection::executeQuery($query, $id);
    }

    private function createCPVCModel($row): CPVC
    {
        return new CPVC(
            $row['idTinh'],
            $row['idVC'],
            $row['chiPhiVC']
        );
    }
    public function readDatabase(): array
    {
        return $this->getAll();
    }
}