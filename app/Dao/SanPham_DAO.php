<?php
namespace App\Dao;

use App\Bus\Hang_BUS;
use App\Bus\LoaiSanPham_BUS;
use App\Interface\DAOInterface;
use App\Models\Hang;
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

    public function getById($id) {
        $query = "SELECT * FROM sanpham WHERE id = ?";
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
        $sql = "INSERT INTO SanPham (tenSanPham, idHang, idLSP, moTa, donGia, thoiGianBaoHanh, trangThaiHD) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $args = [$e->getTenSanPham(), $e->getIdHang()->getId(), $e->getIdLSP()->getId(), $e->getMoTa(), $e->getDonGia(), $e->getThoiGianBaoHanh(), $e->getTrangThaiHD()];
        return database_connection::executeQuery($sql, ...$args);
    }

    public function update($e): int
    {
        $sql = "UPDATE SanPham SET tenSanPham = ?, idHang = ?, soLuong = ?, moTa = ?, donGia = ?, thoiGianBaoHanh = ?, trangThaiHD = ?) 
        WHERE id = ?";
        $args = [$e->getTenSanPham(), $e->getIdHang(), $e->getIdLSP(), $e->getMoTa(), $e->getDonGia(), $e->getThoiGianBaoHanh(), $e->getTrangThaiHD(), $e->getId()];
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
        $id = $rs['ID'];
        $tenSanPham = $rs['TENSANPHAM'];
        $idHang = app(Hang_BUS::class)->getModelById($rs['IDHANG']);
        $idLSP = app(LoaiSanPham_BUS::class)->getModelById($rs['IDLSP']);
        $moTa = $rs['MOTA'];
        $donGia = $rs['DONGIA'];
        $thoiGianBaoHanh = $rs['THOIGIANBAOHANH'];
        $trangThaiHD = $rs['TRANGTHAIHD'];
        return new SanPham($id, $tenSanPham, $idHang, $idLSP, $moTa, $donGia, $thoiGianBaoHanh, $trangThaiHD);
    }

    public function getAll() : array {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM sanpham");
        while($row = $rs->fetch_assoc()) {
            $model = $this->createSanPhamModel($row);
            array_push($list, $model);
        }
        return $list;
    }

    public function getAllModelsActive() : array {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM sanpham WHERE TRANGTHAIHD = 1");
        while($row = $rs->fetch_assoc()) {
            $model = $this->createSanPhamModel($row);
            array_push($list, $model);
        }
        return $list;
    }

    public function searchByLoaiSanPham($idLSP) {
        $list = [];
        $query = "SELECT * FROM SANPHAM WHERE IDLSP = ?";
        $rs = database_connection::executeQuery($query, $idLSP);
        while($row = $rs->fetch_assoc()) {
            $model = $this->createSanPhamModel($row);
            array_push($list, $model);
        }
        return $list;
    }

    public function searchByHang($idHang) {
        $list = [];
        $query = "SELECT * FROM SANPHAM WHERE IDHANG = ?";
        $rs = database_connection::executeQuery($query, $idHang);
        while($row = $rs->fetch_assoc()) {
            $model = $this->createSanPhamModel($row);
            array_push($list, $model);
        }
        return $list;
    }

    public function searchByLSPAndHang($lsp,$hang) {
        $list = [];
        $query = "SELECT * FROM SANPHAM WHERE IDLSP = ? AND IDHANG = ?";
        $rs = database_connection::executeQuery($query, $lsp, $hang);
        while($row = $rs->fetch_assoc()) {
            $model = $this->createSanPhamModel($row);
            array_push($list, $model);
        }
        return $list;
    }

    public function getTop4ProductWasHigestSale() {
        $list = [];
        $query = "SELECT 
                        sp.ID AS IDSanPham,
                        sp.TENSANPHAM,
                        COUNT(cthd.SOSERI) AS SoLanXuatHien
                    FROM cthd
                    JOIN hoadon hd ON cthd.IDHD = hd.ID
                    JOIN ctsp ON cthd.SOSERI = ctsp.SOSERI
                    JOIN sanpham sp ON ctsp.IDSP = sp.ID
                    WHERE hd.TRANGTHAI = 'PAID'
                    GROUP BY sp.ID, sp.TENSANPHAM
                    ORDER BY SoLanXuatHien DESC
                    LIMIT 4";
        $rs = database_connection::executeQuery($query);
        while($row = $rs->fetch_assoc()) {
            $model = $this->getById($row['IDSanPham']);
            array_push($list, $model);
        }
        return $list;
    }

    public function getStock($idPd) {
        $query = "SELECT sp.ID, COUNT(ctsp.SOSERI) AS SoLuongSoSeri
                    FROM sanpham sp
                    JOIN ctsp ON sp.ID = ctsp.IDSP
                    WHERE sp.ID = ? AND ctsp.trangThaiHD = 1
                    GROUP BY sp.ID";
        $result = database_connection::executeQuery($query, $idPd);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row) {
                return $row["SoLuongSoSeri"];
            }
        }
        return null;
    }

}