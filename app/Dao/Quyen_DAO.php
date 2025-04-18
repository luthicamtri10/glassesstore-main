<?php
namespace App\Dao;

use App\Interface\DAOInterface;
use App\Models\Quyen;
use App\Services\database_connection;
use Exception;
use InvalidArgumentException;

use function Laravel\Prompts\alert;

class Quyen_DAO implements DAOInterface {
    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM Quyen");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createQuyenModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    public function createQuyenModel($rs) {
        $id = $rs['ID'];
        $tenQuyen = $rs['TENQUYEN'];
        $trangThaiHD = $rs['TRANGTHAIHD'];
        return new Quyen($id, $tenQuyen, $trangThaiHD);
    }
    public function getAll() : array {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM QUYEN");
        while($row = $rs->fetch_assoc()) {
            $model = $this->createQuyenModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    public function getById($id) {
        $query = "SELECT * FROM QUYEN WHERE id = ?";
        $result = database_connection::executeQuery($query, $id);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row) {
                return $this->createQuyenModel($row);
            }
        }
        return null;
    }
    public function insert($model): int {
        $query = "INSERT INTO Quyen (tenQuyen, trangThaiHD) VALUES (?,?)";
        $args = [$model->getTenQuyen(), $model->getTrangThaiHD()];
        return database_connection::executeQuery($query, ...$args);
    }
    public function update($model): int {
        $query = "UPDATE QUYEN SET tenQuyen = ?, trangThaiHD = ? WHERE id = ?";
        $args = [$model->getTenQuyen(), $model->getTrangThaiHD(), $model->getId()];
        $result = database_connection::executeUpdate($query, ...$args);
        return is_int($result) ? $result : 0;  
    }
    public function delete($id): int
    {
        $query = "UPDATE QUYEN SET trangThaiHD = false WHERE id = ?";
        $result = database_connection::executeUpdate($query, ...[$id]);
        
        return is_int($result) ? $result : 0;
    }

    public function search($value, $columns): array
    {
        $list = [];
        $conditions = implode(" OR ", array_map(fn($col) => "$col LIKE ?", $columns));
        $query = "SELECT * FROM QUYEN WHERE $conditions";
        $params = array_fill(0, count($columns), "%$value%");
        $rs = database_connection::executeQuery($query, ...$params);
        
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createQuyenModel($row);
            array_push($list, $model);
        }
        return $list;
    }

}   
?>