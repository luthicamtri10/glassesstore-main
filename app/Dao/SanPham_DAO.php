<?php

namespace App\Dao;

use App\Bus\Hang_BUS;
use App\Bus\LoaiSanPham_BUS;
use App\Interface\DAOInterface;
use App\Models\SanPham;
use App\Services\database_connection;
use App\Exceptions\ValidationException;

class SanPham_DAO implements DAOInterface{

    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM SanPham");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createSanPhamModel($row);
            array_push($list, $model);
        }
        return $list;
    }

    public function getById($id) {
        $query = "SELECT * FROM SanPham WHERE ID = ?";
        $result = database_connection::executeQuery($query, $id);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row) {
                return $this->createSanPhamModel($row);
            }
        }
        return null;
    }

    public function insert($e): int
    {
        $sql = "INSERT INTO SanPham (tenSanPham, idHang, idLSP, soLuong, moTa, donGia, thoiGianBaoHanh, trangThaiHD) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $args = [$e->getTenSanPham(), $e->getIdHang(), $e->getIdLSP(), $e->getSoLuong(), $e->getMoTa(), $e->getDonGia(), $e->getThoiGianBaoHanh(), $e->getTrangThaiHD()];
        return database_connection::executeQuery($sql, ...$args);
    }

    public function update($e): int
    {
        $sql = "UPDATE SanPham SET tenSanPham = ?, idHang = ?, idLSP = ?, soLuong = ?, moTa = ?, donGia = ?, thoiGianBaoHanh = ?, trangThaiHD = ? 
        WHERE ID = ?";
        $args = [$e->getTenSanPham(), $e->getIdHang(), $e->getIdLSP(), $e->getSoLuong(), $e->getMoTa(), $e->getDonGia(), $e->getThoiGianBaoHanh(), $e->getTrangThaiHD(), $e->getId()];
        $result = database_connection::executeUpdate($sql, ...$args);
        return is_int($result)? $result : 0;
    }

    public function delete(int $id): int
    {
        $sql = "UPDATE SanPham SET trangThaiHD = false WHERE ID = ?";
        $result = database_connection::executeUpdate($sql, $id);
        return is_int($result)? $result : 0;
    }

    public function search(string $condition, array $columnNames): array
    {
        // Danh sách các cột được phép tìm kiếm
        $allowedColumns = ['ID', 'TENSANPHAM', 'IDHANG', 'IDLSP', 'SOLUONG', 'MOTA', 'DONGIA', 'THOIGIANBAOHANH', 'TRANGTHAIHD'];
        
        $column = $columnNames[0];
        // Kiểm tra xem cột có được phép tìm kiếm không
        if (!in_array(strtoupper($column), $allowedColumns)) {
            return [];
        }

        $query = "SELECT * FROM SanPham WHERE $column LIKE ?";
        $args = ["%" . $condition . "%"];
        $rs = database_connection::executeQuery($query, ...$args);
        $productList = [];
        while ($row = $rs->fetch_assoc()) {
            $productModel = $this->createSanPhamModel($row);
            array_push($productList, $productModel);
        }
        return $productList;
    }

    public function createSanPhamModel($rs) {
        $id = $rs['ID'];
        $tenSanPham = $rs['TENSANPHAM'];
        
        // Khởi tạo trực tiếp các đối tượng BUS
        $hangBUS = new Hang_BUS();
        $loaiSanPhamBUS = new LoaiSanPham_BUS();
        
        $idHang = $hangBUS->getModelById($rs['IDHANG']);
        $idLSP = $loaiSanPhamBUS->getModelById($rs['IDLSP']);
        
        $soLuong = $rs['SOLUONG'];
        $moTa = $rs['MOTA'];
        $donGia = $rs['DONGIA'];
        $thoiGianBaoHanh = $rs['THOIGIANBAOHANH'];
        $trangThaiHD = $rs['TRANGTHAIHD'];
        
        return new SanPham($id, $tenSanPham, $idHang, $idLSP, $soLuong, $moTa, $donGia, $thoiGianBaoHanh, $trangThaiHD);
    }

    public function getAll() : array {
        return $this->readDatabase();
    }

    private function validateModel($model) {
        if ($model->getSoLuong() <= 0) {
            throw new ValidationException("Số lượng phải lớn hơn 0");
        }
        if ($model->getDonGia() <= 0) {
            throw new ValidationException("Giá bán phải lớn hơn 0");
        }
    }
}