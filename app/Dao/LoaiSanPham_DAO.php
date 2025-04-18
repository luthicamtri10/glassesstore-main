<?php
namespace App\Dao;

use App\Interface\DAOInterface;
use App\Models\LoaiSanPham;
use App\Services\database_connection;

class LoaiSanPham_DAO implements DAOInterface {

  
    public function readDatabase(): array {
        $list = [];
        $query = "SELECT * FROM loaisanpham"; 

      
        $rs = database_connection::executeQuery($query);
        while ($row = $rs->fetch_assoc()) {
           
            $list[] = $this->createLoaiSanPhamModel($row);
        }

        return $list;
    }


    public function getAll(): array {
        $list = [];
        $query = "SELECT * FROM loaisanpham";

        $rs = database_connection::executeQuery($query);
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createLoaiSanPhamModel($row);
        }
        
        return $list;
    }

 
    private function createLoaiSanPhamModel($row){
        // return new LoaiSanPham(
        //     $row['ID'], $row['TENLSP'], $row['MOTA'], $row['TRANGTHAIHD']
        // );
        $id = $row['ID'];
        $tenlsp = $row['TENLSP'];
        $mota = $row['MOTA'];
        $trangThaiHD = $row['TRANGTHAIHD'];
        return new LoaiSanPham($id, $tenlsp, $mota, $trangThaiHD);
    }

    public function getById($id) {
        $query = "SELECT * FROM LOAISANPHAM WHERE id = ?";
        $result = database_connection::executeQuery($query, $id);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row) {
                return $this->createLoaiSanPhamModel($row);
            }
        }
        return null;
    }

    public function insert($model): int {
        $query = "INSERT INTO loaisanpham (ID, TENLSP, MOTA, TRANGTHAIHD) VALUES (?, ?, ?, ?)";
        $args = [ $model->getId(), $model->gettenLSP(), $model->getmoTa(), $model->gettrangThaiHD()];
        $result = database_connection::executeUpdate($query, ...$args);
        return is_int($result) ? $result : 0;
    }


    public function update($model): int {
        $query = "UPDATE loaisanpham SET TENLSP = ?, MOTA = ?, TRANGTHAIHD = ? WHERE ID = ?";
        $args = [$model->gettenLSP(), $model->getmoTa(), $model->gettrangThaiHD(), $model->getId()];
        $result = database_connection::executeUpdate($query, ...$args);
        return is_int($result) ? $result : 0;
    }

  
    public function delete($id): int {
        $query = "DELETE FROM LOAISANPHAM WHERE ID = ?";
        return database_connection::executeQuery($query, $id);
    }

    public function search($value, $columns): array {
        $list = [];
        if (empty($columns)) {
            $query = "SELECT * FROM LOAISANPHAM WHERE TENLSP LIKE ? OR MOTA LIKE ?";
            $args = array_fill(0, 2, "%$value%");
        } else {
            $whereClauses = implode(" LIKE ? OR ", $columns) . " LIKE ?";
            $query = "SELECT * FROM LOAISANPHAM WHERE $whereClauses";
            $args = array_fill(0, count($columns), "%$value%");
        }

        $rs = database_connection::executeQuery($query, ...$args);
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createLoaiSanPhamModel($row);
        }

        return $list;
    }
}
?>
