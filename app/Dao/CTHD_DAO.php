<?php

use App\Interface\DAOInterface;
use App\Models\CTHD;
use App\Models\SanPham;
use App\Services\database_connection;

class CTHD_DAO{

    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM CTHD");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createCTHDModel($row);
            array_push($list, $model);
        }
        return $list;
    }

    public function insert($e): int
    {
        $sql = "INSERT INTO CTHD (idSP, soLuong, giaLucDat, soSeri, trangThaiHD) 
        VALUES (?, ?, ?, ?, ?)";
        $args = [$e->getIdSP(), $e->getSoLuong(), $e->getGiaLucDat(), $e->getSoSeri(), $e->getTrangThaiHD()];
        return database_connection::executeQuery($sql, ...$args);
    }

    public function update($e): int
    {
        $sql = "UPDATE CTHD SET trangThaiHD = ?) 
        WHERE idHD = ?";
        $result = database_connection::executeUpdate($sql, ...[$e]);
        return is_int($result)? $result : 0;
    }

    public function createCTHDModel($rs) {
        $idHD = $rs['idHD'];
        $idSP = $rs['idSP'];
        $soLuong = $rs['soLuong'];
        $giaLucDat = $rs['giaLucDat'];
        $soSeri = $rs['soSeri'];
        $trangThaiHD = $rs['trangThaiHD'];

        return new CTHD($idHD, $idSP, $soLuong, $giaLucDat, $soSeri, $trangThaiHD);
    }

    public function getAll() : array {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM CTHD");
        while($row = $rs->fetch_assoc()) {
            $model = $this->createCTHDModel($row);
            array_push($list, $model);
        }
        return $list;
    }

}