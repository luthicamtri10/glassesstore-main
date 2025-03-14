<?php
namespace App\Dao;

use App\Interface\DAOInterface;
use App\Models\ChucNang;
use App\Services\database_connection;
use Exception;
use InvalidArgumentException;

use function Laravel\Prompts\alert;

class ChucNang_DAO implements DAOInterface {
    private static $instance;
    public static function getInstance()
    {
        if(self::$instance == null) {
            self::$instance = new ChucNang_DAO();
        }
        return self::$instance;
    }
    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM ChucNang");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createChucNangModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    public function createChucNangModel($rs) {
        $id = $rs['ID'];
        $tenChucNang = $rs['TENCHUCNANG'];
        $trangThaiHD = $rs['TRANGTHAIHD'];
        return new ChucNang($id, $tenChucNang, $trangThaiHD);
    }
    public function getAll() : array {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM ChucNang");
        while($row = $rs->fetch_assoc()) {
            $model = $this->createChucNangModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    public function getById($id) {
        $query = "SELECT * FROM ChucNang WHERE id = ?";
        $result = database_connection::executeQuery($query, $id);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row) {
                return $this->createChucNangModel($row);
            }
        }
        return null;
    }
    public function insert($model): int {
        $query = "INSERT INTO ChucNang (tenChucNang, trangThaiHD) VALUES (?,?)";
        $args = [$model->getTenChucNang(), $model->getTrangThaiHD()];
        return database_connection::executeQuery($query, ...$args);
    }
    // public function update($model): int {
    //     $query = "UPDATE ChucNang SET tenChucNang = ?, trangThaiHD = ? WHERE id = ?";
    //     $args = [$model->getTenChucNang(), $model->getTrangThaiHD(), $model->getId()];
    //     $result = database_connection::executeUpdate($query, ...$args);
    //     if ($result) {
    //         alert("Success!");
    //     } else alert("Error when update");
    //     return is_int($result) ? $result : 101; 
    // }
    public function update($model): int {
        $query = "UPDATE ChucNang SET tenChucNang = ?, trangThaiHD = ? WHERE id = ?";
        $args = [$model->getTenChucNang(), $model->getTrangThaiHD(), $model->getId()];
        $result = database_connection::executeUpdate($query, ...$args);
        return is_int($result) ? $result : 0;  
    }
    
    
    public function delete($id): int
    {
        $query = "UPDATE ChucNang SET trangThaiHD = false WHERE id = ?";
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
            $query = "SELECT * FROM ChucNang WHERE id LIKE ? OR tenChucNang LIKE ? OR trangThaiHD LIKE ? ";
            $args = array_fill(0,  5, "%" . $condition . "%");
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM ChucNang WHERE $column LIKE ?";
            $args = ["%" . $condition . "%"];
        } else {
            $query = "SELECT * FROM ChucNang WHERE " . implode(" LIKE ? OR ", $columnNames) . " LIKE ?";
            $args = array_fill(0, count($columnNames), "%" . $condition . "%");
        }
        $rs = database_connection::executeQuery($query, ...$args);
        $cartsList = [];
        while ($row = $rs->fetch_assoc()) {
            $cartsModel = $this->createChucNangModel($row);
            array_push($cartsList, $cartsModel);
        }
        if (count($cartsList) === 0) {
            return [];
        }
        return $cartsList;
    }

}   
?>