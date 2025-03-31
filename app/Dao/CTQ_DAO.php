<?php
namespace App\Dao;

use App\Interface\DAOInterface;
use App\Models\CTQ;
use App\Models\Tinh;
use App\Services\database_connection;
use Exception;
use InvalidArgumentException;

use function Laravel\Prompts\alert;

class CTQ_DAO implements DAOInterface {
    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM CTQ");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createCTQModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    public function createCTQModel($rs) {
        $idNguoiDung = $rs['IDNGUOIDUNG'];
        $idQuyen = $rs['IDQUYEN'];
        $thaoTac = $rs['THAOTAC'];
        $trangThaiHD = $rs['TRANGTHAIHD'];
        return new CTQ($idNguoiDung, $idQuyen, $thaoTac, $trangThaiHD);
    }
    public function getAll() : array {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM CTQ");
        while($row = $rs->fetch_assoc()) {
            $model = $this->createCTQModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    public function getById($id) {
        $query = "SELECT * FROM CTQ WHERE idQuyen = ?";
        $result = database_connection::executeQuery($query, $id);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row) {
                return $this->createCTQModel($row);
            }
        }
        return null;
    }
    public function insert($model): int {
        $query = "INSERT INTO CTQ (idQuyen, idChucNang, thaoTac, trangThaiHD) VALUES (?,?,?,?)";
        $args = [$model->getIdQuyen(), $model->getIdChucNang(), $model->getThaoTac(), $model->getTrangThaiHD()];
        return database_connection::executeQuery($query, ...$args);
    }
    public function update($model): int {
        $query = "UPDATE CTQ SET idChucNang = ?, thaoTac = ?, trangThaiHD = ? WHERE idQuyen = ?";
        $args = [$model->getIdChucNang(), $model->getThaoTac(), $model->getTrangThaiHD(), $model->getIdQuyen()];
        $result = database_connection::executeUpdate($query, ...$args);
        return is_int($result) ? $result : 0;  
    }
    public function delete(int $id): int
    {
        $query = "UPDATE CTQ SET trangThaiHD = false WHERE idQuyen = ?";
        $result = database_connection::executeUpdate($query, ...[$id]);
        
        return is_int($result) ? $result : 0;
    }
    public function deleteByIdQuyenAndIdChucNang($idQuyen, $idChucNang): int
    {
        $query = "UPDATE CTQ SET trangThaiHD = false WHERE idQuyen = ? AND idChucNang = ?";
        $result = database_connection::executeUpdate($query, $idQuyen, $idChucNang);
        
        return is_int($result) ? $result : 0;
    }

    public function search(string $condition, $columnNames): array
    {
        if (empty($condition)) {
            throw new InvalidArgumentException("Search condition cannot be empty or null");
        }
        $query = "";
        if ($columnNames === null || count($columnNames) === 0) {
            $query = "SELECT * FROM CTQ WHERE idquyen LIKE ? OR idChucNang LIKE ? OR thaoTac LIKE ? OR trangThaiHD LIKE ? ";
            $args = array_fill(0,  4, "%" . $condition . "%");
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM CTQ WHERE $column LIKE ?";
            $args = ["%" . $condition . "%"];
        } else {
            $query = "SELECT * FROM CTQ WHERE " . implode(" LIKE ? OR ", $columnNames) . " LIKE ?";
            $args = array_fill(0, count($columnNames), "%" . $condition . "%");
        }
        $rs = database_connection::executeQuery($query, ...$args);
        $list = [];
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createCTQModel($row);
            array_push($list, $model);
        }
        if (count($list) === 0) {
            return [];
        }
        return $list;
    }

}   
?>