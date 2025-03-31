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

 
    private function createLoaiSanPhamModel($row): LoaiSanPham {
        return new LoaiSanPham(
            $row['ID'], $row['TENLSP'], $row['MOTA'], $row['TRANGTHAIHD']
        );
    }

    public function getById($id): ?LoaiSanPham {
        $query = "SELECT * FROM loaisanpham WHERE ID = ?";
        $result = database_connection::executeQuery($query, [$id]);
        if ($result && $result->num_rows > 0) {
            return $this->createLoaiSanPhamModel($result->fetch_assoc());
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

  
    public function delete(int $id): int {
        $query = "DELETE FROM loaisanpham WHERE ID = ?";
        $result = database_connection::executeUpdate($query, $id);
        return is_int($result) ? $result : 0;
    }

    public function search(string $condition, array $columnNames = []): array {
        $list = [];
        if (empty($columnNames)) {
            $query = "SELECT * FROM loaisanpham WHERE TENLSP LIKE ? OR MOTA LIKE ?";
            $args = array_fill(0, 2, "%$condition%");
        } else {
            $whereClauses = implode(" LIKE ? OR ", $columnNames) . " LIKE ?";
            $query = "SELECT * FROM loaisanpham WHERE $whereClauses";
            $args = array_fill(0, count($columnNames), "%$condition%");
        }

        $rs = database_connection::executeQuery($query, ...$args);
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createLoaiSanPhamModel($row);
        }

        return $list;
    }
}
?>
