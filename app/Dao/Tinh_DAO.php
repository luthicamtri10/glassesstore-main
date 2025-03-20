<?php
namespace App\Dao;

use App\Interface\DAOInterface;
use App\Models\Tinh;
use App\Services\database_connection;
use Exception;
use InvalidArgumentException;

use function Laravel\Prompts\alert;

class Tinh_DAO implements DAOInterface {
    private static $instance;
    public static function getInstance()
    {
        if(self::$instance == null) {
            self::$instance = new Tinh_DAO();
        }
        return self::$instance;
    }
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

    public function search(string $condition, $columnNames): array
    {
        if (empty($condition)) {
            throw new InvalidArgumentException("Search condition cannot be empty or null");
        }
        $query = "";
        if ($columnNames === null || count($columnNames) === 0) {
            $query = "SELECT * FROM TINH WHERE id LIKE ? OR tenTinh LIKE ? OR trangThaiHD LIKE ? ";
            $args = array_fill(0,  3, "%" . $condition . "%");
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM TINH WHERE $column LIKE ?";
            $args = ["%" . $condition . "%"];
        } else {
            $query = "SELECT * FROM TINH WHERE " . implode(" LIKE ? OR ", $columnNames) . " LIKE ?";
            $args = array_fill(0, count($columnNames), "%" . $condition . "%");
        }
        $rs = database_connection::executeQuery($query, ...$args);
        $list = [];
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createTinhModel($row);
            array_push($list, $model);
        }
        if (count($list) === 0) {
            return [];
        }
        return $list;
    }

}   
?>