<?php

namespace App\Dao;

use App\Models\CPVC;
use App\Services\database_connection;
use App\Interface\DAOInterface;
use Exception;
use InvalidArgumentException;

class CPVC_DAO implements DAOInterface
{
    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM CPVC");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createCPVCModel($row);
            array_push($list, $model);
        }
        return $list;
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
        if (empty($value)) {
            throw new InvalidArgumentException("Search condition cannot be empty or null");
        }
        $query = "";
        if ($columns === null || count($columns) === 0) {
            $query = "SELECT * FROM CPVC WHERE IDTINH LIKE ? OR IDVC LIKE ? OR CHIPHIVC LIKE ?";
            $args = array_fill(0, 3, "%" . $value . "%");
        } else if (count($columns) === 1) {
            $column = $columns[0];
            $query = "SELECT * FROM CPVC WHERE $column LIKE ?";
            $args = ["%" . $value . "%"];
        } else {
            $query = "SELECT * FROM CPVC WHERE " . implode(" LIKE ? OR ", $columns) . " LIKE ?";
            $args = array_fill(0, count($columns), "%" . $value . "%");
        }
        $rs = database_connection::executeQuery($query, ...$args);
        $list = [];
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createCPVCModel($row);
            array_push($list, $model);
        }
        if (count($list) === 0) {
            return [];
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
        $query = "UPDATE CPVC SET CHIPHIVC = ? WHERE IDTINH = ? AND IDVC = ?";
        $args = [$model->getCHIPHIVC(), $model->getIDTINH(), $model->getIDVC()];
        $result = database_connection::executeUpdate($query, ...$args);
        
        if ($result === false) {
            throw new \Exception("Cập nhật thất bại");
        }
        
        return 1; // Trả về 1 nếu cập nhật thành công
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
 
}