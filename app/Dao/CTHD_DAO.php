<?php
namespace App\Dao;

use App\Bus\CTSP_BUS;
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
        $sql = "INSERT INTO CTHD (giaLucDat, soSeri, trangThaiHD) 
        VALUES (?, ?, ?)";
        $args = [$e->getGiaLucDat(), $e->getSoSeri(), $e->getTrangThaiHD()];
        return database_connection::executeQuery($sql, ...$args);
    }

    public function update($e): int
    {
        $sql = "UPDATE CTHD SET trangThaiBD = ?) 
        WHERE IDHD = ?";
        $result = database_connection::executeUpdate($sql, ...[$e]);
        return is_int($result)? $result : 0;
    }

    public function createCTHDModel($rs) {
        $idHD = $rs['IDHD'];
        $giaLucDat = $rs['GIALUCDAT'];
        $soSeri = $rs['SOSERI'];
        $trangThaiHD = $rs['TRANGTHAIBH'];

        return new CTHD($idHD, $giaLucDat, $soSeri, $trangThaiHD);
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

    public function checkSPIsSold($idSP) {
        $list = $this->getAll();
        foreach ($list as $key) {
            # code...
            $sp = app(CTSP_BUS::class)->getSPBySoSeri($key->getSoSeri());
            if($sp->getId() == $idSP) {
                return true;
            }
        }
        return false;
    }

    public function getCTHDbyIDHD($id) {
        $list = [];
        $query = "SELECT * FROM CTHD WHERE IDHD = ?";
        $rs = database_connection::executeQuery($query, $id);
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createCTHDModel($row);
            array_push($list, $model);
        }
        return $list;
    }

}