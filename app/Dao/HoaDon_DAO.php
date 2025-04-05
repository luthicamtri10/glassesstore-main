<?php
namespace App\Dao;

use App\Interface\DAOInterface;
use App\Models\HoaDon;
use App\Services\database_connection;

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
        $args = [$e->getIdKhachHang(), $e->getIdNhanVien(), $e->getTongTien(), $e->getTongTien(), $e->getIdPTTT(), $e->getNgayTao(), $e->getIdDVVC(), $e->getTrangThai()];
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
        $id = $rs['id'];
        $idKhachHang = $rs['idKhachHang'];
        $idNhanVien = $rs['idNhanVien'];
        $tongTien = $rs['tongTien'];
        $idPTTT = $rs['idPTTT'];
        $ngayTao = $rs['ngayTao'];
        $idDVVC = $rs['idDVVC'];
        $trangThai = $rs['trangThai'];
        return new HoaDon($id, $idKhachHang, $idNhanVien, $tongTien, $idPTTT, $ngayTao, $idDVVC, $trangThai);
    }

    public function getAll() : array {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM HoaDon");
        while($row = $rs->fetch_assoc()) {
            $model = $this->createHoaDonModel($row);
            array_push($list, $model);
        }
        return $list;
    }
}