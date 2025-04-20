<?php
namespace App\Dao;

use App\Bus\DVVC_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\PTTT_BUS;
use App\Enum\HoaDonEnum;
use App\Interface\DAOInterface;
use App\Models\HoaDon;
use App\Services\database_connection;
use function Laravel\Prompts\error;

class HoaDon_DAO{

    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM HoaDon");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createHoaDonModel($row);
            array_push($list, $model);
        }
        return $list;
    }

    public function insert($e): int
    {
        $sql = "INSERT INTO HoaDon (idKhachHang, idNhanVien, tongTien, idPTTT, ngayTao, idDVVC, trangThai)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $args = [$e->getIdKhachHang()->getId(), $e->getIdNhanVien()->getId(), $e->getTongTien(), $e->getTongTien(), $e->getIdPTTT()->getId(), $e->getNgayTao(), $e->getIdDVVC()->getId(), $e->getTrangThai()];
        return database_connection::executeQuery($sql, ...$args);
    }

    public function update($e): int
    {
        $sql = "UPDATE HoaDon SET trangThai = ?) 
        WHERE id = ?";
        $result = database_connection::executeUpdate($sql, ...[$e]);
        return is_int($result)? $result : 0;
    }

    public function search(string $condition, array $columnNames): array
    {
        $column = $columnNames[0];
        $query = "SELECT * FROM HoaDon WHERE $column LIKE ?";
        $args = ["%" . $condition . "%"];
        $rs = database_connection::executeQuery($query, ...$args);
        $cartsList = [];
        while ($row = $rs->fetch_assoc()) {
            $cartsModel = $this->createHoaDonModel($row);
            array_push($cartsList, $cartsModel);
        }
        if (count($cartsList) === 0) {
            return [];
        }
        return $cartsList;
    }



    public function createHoaDonModel($rs) {
        $id = $rs['ID'];
        $idKhachHang = app(NguoiDung_BUS::class)->getModelById($rs['IDKHACHHANG']);
        $idNhanVien = app(NguoiDung_BUS::class)->getModelById($rs['IDNHANVIEN']);
        $tongTien = $rs['TONGTIEN'];
        $idPTTT = app(PTTT_BUS::class)->getModelById($rs['IDPTTT']);
        if (!$idPTTT) {
            throw new \Exception("Không tìm thấy phương thức thanh toán với ID: " . $rs['IDPTTT']);
        }
        $ngayTao = $rs['NGAYTAO'];
        $idDVVC = app(DVVC_BUS::class)->getModelById($rs['IDDVVC']);
        $trangThai = $rs['TRANGTHAI'];
        switch($trangThai) {
            case 'PAID':
                $trangThai = HoaDonEnum::PAID;
                break;
            case 'PENDING':
                $trangThai = HoaDonEnum::PENDING;
                break;
            case 'EXPIRED':
                $trangThai = HoaDonEnum::EXPIRED;
                break;
            case 'CANCELLED':
                $trangThai = HoaDonEnum::CANCELLED;
                break;
            case 'REFUNDED':
                $trangThai = HoaDonEnum::REFUNDED;
                break;
            default:
                error("Can not create model");
                break;
        }
        
        return new HoaDon($id, $idKhachHang, $idNhanVien, $tongTien, $idPTTT, $ngayTao, $idDVVC, $trangThai);
    }

    public function getAll() : array {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM hoadon");
        while($row = $rs->fetch_assoc()) {
            $model = $this->createHoaDonModel($row);
            array_push($list, $model);
        }
        return $list;
    }
}