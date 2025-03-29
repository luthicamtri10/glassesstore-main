<?php
namespace App\Dao;

use App\Interface\DAOInterface;
use App\Models\KhuyenMai;
use App\Services\database_connection;

class KhuyenMai_DAO implements DAOInterface {
    
    public function readDatabase(): array {
        $list = [];
        $query = "SELECT * FROM KhuyenMai";
        
        $rs = database_connection::executeQuery($query);
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createKhuyenMaiModel($row);
        }
        
        return $list;
    }

    private function createKhuyenMaiModel($row): KhuyenMai {
        return new KhuyenMai(
            $row['ID'], $row['IDSANPHAM'], $row['DIEUKIEN'], 
            $row['PHANTRAMGIAMGIA'], $row['NGAYBATDAU'], $row['NGAYKETTHUC'],
            $row['MOTA'], $row['SOLUONGTON']
        );
    }

    public function getAll(): array {
        $list = [];
        $query = "SELECT * FROM KhuyenMai";

        $rs = database_connection::executeQuery($query);
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createKhuyenMaiModel($row);
        }
        
        return $list;
    }

    public function getById($id): ?KhuyenMai {
        $query = "SELECT * FROM KhuyenMai WHERE ID = ?";
        
        $result = database_connection::executeQuery($query, [$id]);
        if ($result && $result->num_rows > 0) {
            return $this->createKhuyenMaiModel($result->fetch_assoc());
        }
        return null;
    }

    public function insert($model): int {
        $query = "INSERT INTO KhuyenMai (ID, IDSANPHAM, DIEUKIEN, PHANTRAMGIAMGIA, NGAYBATDAU, NGAYKETTHUC, MOTA, SOLUONGTON) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
        $args = [
            $model->getId(), 
            $model->getIdSanPham(), 
            $model->getdieuKien(), 
            $model->getphanTramGiamGia(),
            $model->getngayBatDau(), 
            $model->getngayKetThuc(), 
            $model->getmoTa(), 
            $model->getsoLuongTon()
        ];
    
        $result = database_connection::executeUpdate($query, ...$args);
        return is_int($result) ? $result : 0;
    }
    

    public function update($model): int {
        $query = "UPDATE KhuyenMai SET IDSANPHAM = ?, DIEUKIEN = ?, PHANTRAMGIAMGIA = ?, NGAYBATDAU = ?, 
                  NGAYKETTHUC = ?, MOTA = ?, SOLUONGTON = ? WHERE ID = ?";

        $args = [
            $model->getIdSanPham(), $model->getdieuKien(), $model->getphanTramGiamGia(),
            $model->getngayBatDau(), $model->getngayKetThuc(), $model->getmoTa(),
            $model->getsoLuongTon(), $model->getId()
        ];

        $result = database_connection::executeUpdate($query, ...$args);
        return is_int($result) ? $result : 0;
    }

    public function delete(int $id): int {
        $query = "DELETE FROM KhuyenMai WHERE ID = ?";
        
        $result = database_connection::executeUpdate($query, $id);
        return is_int($result) ? $result : 0;
    }

    public function search(string $condition, array $columnNames = []): array {
        $list = [];
        if (empty($columnNames)) {
            $query = "SELECT * FROM KhuyenMai WHERE IDSANPHAM LIKE ? OR DIEUKIEN LIKE ? OR MOTA LIKE ?";
            $args = array_fill(0, 3, "%$condition%");
        } else {
            $whereClauses = implode(" LIKE ? OR ", $columnNames) . " LIKE ?";
            $query = "SELECT * FROM KhuyenMai WHERE $whereClauses";
            $args = array_fill(0, count($columnNames), "%$condition%");
        }

        $rs = database_connection::executeQuery($query, ...$args);
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createKhuyenMaiModel($row);
        }

        return $list;
    }
}
?>
