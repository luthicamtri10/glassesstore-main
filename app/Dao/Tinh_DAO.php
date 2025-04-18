<?php
namespace App\Dao;

use App\Interface\DAOInterface;
use App\Models\Tinh;
use App\Services\database_connection;
use Exception;
use InvalidArgumentException;

use function Laravel\Prompts\alert;

class Tinh_DAO implements DAOInterface {
    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM TINH");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createTinhModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    public function createTinhModel($rs) {
        $id = $rs['ID'];
        $tenTinh = $rs['TENTINH'];
        $trangThaiHD = $rs['TRANGTHAIHD'];
        return new Tinh($id, $tenTinh, $trangThaiHD);
    }
    public function getAll() : array {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM TINH");
        while($row = $rs->fetch_assoc()) {
            $model = $this->createTinhModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    public function getById($id) {
        $query = "SELECT * FROM Tinh WHERE id = ?";
        $result = database_connection::executeQuery($query, $id);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row) {
                return $this->createTinhModel($row);
            }
        }
        return null;
    }
    public function insert($model): int {
        $query = "INSERT INTO TINH (tenTinh, trangThaiHD) VALUES (?,?)";
        $args = [$model->getTinh(), $model->getTrangThaiHD()];
        return database_connection::executeQuery($query, ...$args);
    }
    public function update($model): int {
        $query = "UPDATE TINH SET tenTinh = ?, trangThaiHD = ? WHERE id = ?";
        $args = [$model->getTenTinh(), $model->getTrangThaiHD(), $model->getId()];
        $result = database_connection::executeUpdate($query, ...$args);
        return is_int($result) ? $result : 0;  
    }
    public function delete($id): int
    {
        $query = "UPDATE TINH SET trangThaiHD = false WHERE id = ?";
        $result = database_connection::executeUpdate($query, ...[$id]);
        
        return is_int($result) ? $result : 0;
    }

    public function search($value, $columns): array
    {
        $list = [];
        $conditions = implode(" OR ", array_map(fn($col) => "$col LIKE ?", $columns));
        $query = "SELECT * FROM TINH WHERE $conditions";
        $params = array_fill(0, count($columns), "%$value%");
        $rs = database_connection::executeQuery($query, ...$params);
        
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createTinhModel($row);
            array_push($list, $model);
        }
        return $list;
    }

}   
?>