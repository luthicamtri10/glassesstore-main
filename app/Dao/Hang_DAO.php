<?php
namespace App\Dao;

use App\Interface\DAOInterface;
use App\Models\Hang;
use App\Services\database_connection;

class Hang_DAO implements DAOInterface {
    public function readDatabase(): array {
        $list = [];
        $query = "SELECT * FROM hang";
        
        $rs = database_connection::executeQuery($query);
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createHangModel($row);
        }
        
        return $list;
    }

    private function createHangModel($row): Hang {
        return new Hang(
            $row['ID'], $row['TENHANG'], $row['MOTA'], $row['TRANGTHAIHD']
        );
    }

    public function getAll(): array {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM hang");
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createHangModel($row);
        }
        return $list;
    }
    
    public function getById($id){
        $query = "SELECT * FROM hang WHERE ID = ?";
        $result = database_connection::executeQuery($query, $id);
        if ($result && $result->num_rows > 0) {
            return $this->createHangModel($result->fetch_assoc());
        }
        return null;
    }

    public function insert($model): int {
        $query = "INSERT INTO hang (ID, TENHANG, MOTA, TRANGTHAIHD) VALUES (?, ?, ?, ?)";
        $args = [$model->getId(), $model->gettenHang(), $model->getmoTa(), $model->gettrangThaiHD()];
        $result = database_connection::executeUpdate($query, ...$args);
        return is_int($result) ? $result : 0;
    }

    public function update($model): int {
        $query = "UPDATE hang SET TENHANG = ?, MOTA = ?, TRANGTHAIHD = ? WHERE ID = ?";
        $args = [$model->gettenHang(), $model->getmoTa(), $model->gettrangThaiHD(), $model->getId()];
        $result = database_connection::executeUpdate($query, ...$args);
        return is_int($result) ? $result : 0;
    }

    public function delete($id): int {
        $query = "DELETE FROM hang WHERE ID = ?";
        return database_connection::executeQuery($query, $id);
    }

    public function search($value, $columns): array {
        $list = [];
        if (empty($columns)) {
            $query = "SELECT * FROM hang WHERE TENHANG LIKE ? OR MOTA LIKE ?";
            $args = array_fill(0, 2, "%$value%");
        } else {
            $whereClauses = implode(" LIKE ? OR ", $columns) . " LIKE ?";
            $query = "SELECT * FROM hang WHERE $whereClauses";
            $args = array_fill(0, count($columns), "%$value%");
        }

        $rs = database_connection::executeQuery($query, ...$args);
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createHangModel($row);
        }

        return $list;
    }
}