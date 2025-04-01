<?php
namespace App\Dao;
use App\Interface\DAOInterface;
use App\Models\SanPham;
use App\Services\database_connection;

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

    public function insert($e): int
    {
        $sql = "INSERT INTO SanPham (tenSanPham, idHang, idLSP, soLuong, moTa, donGia, thoiGianBaoHanh, trangThaiHD) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $args = [$e->getTenSanPham(), $e->getIdHang(), $e->getIdLSP(), $e->getSoLuong(), $e->getMoTa(), $e->getDonGia(), $e->getThoiGianBaoHanh(), $e->getTrangThaiHD()];
        return database_connection::executeQuery($sql, ...$args);
    }

    public function update($e): int
    {
        $sql = "UPDATE SanPham SET tenSanPham = ?, idHang = ?, idLSP = ?, soLuong = ?, moTa = ?, donGia = ?, thoiGianBaoHanh = ?, trangThaiHD = ?) 
        WHERE id = ?";
        $args = [$e->getTenSanPham(), $e->getIdHang(), $e->getIdLSP(), $e->getSoLuong(), $e->getMoTa(), $e->getDonGia(), $e->getThoiGianBaoHanh(), $e->getTrangThaiHD(), $e->getId()];
        $result = database_connection::executeUpdate($sql, ...$args);
        return is_int($result)? $result : 0;
    }

    public function delete(int $id): int
    {
        $sql = "UPDATE SanPham SET trangThaiHD = false WHERE id = ?";
        $result = database_connection::executeUpdate($sql, ...[$id]);
        return is_int($result)? $result : 0;
    }

    public function search(string $condition, array $columnNames): array
    {
        $column = $columnNames[0];
        $query = "SELECT * FROM SanPham WHERE $column LIKE ?";
        $args = ["%" . $condition . "%"];
        $rs = database_connection::executeQuery($query, ...$args);
        $cartsList = [];
        while ($row = $rs->fetch_assoc()) {
            $cartsModel = $this->createSanPhamModel($row);
            array_push($cartsList, $cartsModel);
        }
        if (count($cartsList) === 0) {
            return [];
        }
        return $cartsList;
    }



    public function createSanPhamModel($rs) {
        $id = $rs['id'];
        $tenSanPham = $rs['tenSanPham'];
        $idHang = $rs['idHang'];
        $idLSP = $rs['idLSP'];
        $soLuong = $rs['soLuong'];
        $moTa = $rs['moTa'];
        $donGia = $rs['donGia'];
        $thoiGianBaoHanh = $rs['thoiGianBaoHanh'];
        $trangThaiHD = $rs['trangThaiHD'];

        return new SanPham($id, $tenSanPham, $idHang, $idLSP, $soLuong, $moTa, $donGia, $thoiGianBaoHanh, $trangThaiHD);
    }

    public function getAll() : array {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM SanPham");
        while($row = $rs->fetch_assoc()) {
            $model = $this->createSanPhamModel($row);
            array_push($list, $model);
        }
        return $list;
    }

}