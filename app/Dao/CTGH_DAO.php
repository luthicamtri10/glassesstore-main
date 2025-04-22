<?php

namespace App\Dao;

use App\Bus\CTSP_BUS;
use App\Bus\GioHang_BUS;
use App\Bus\SanPham_BUS;
use App\Models\CTGH;
use App\Models\CTSP;
use App\Services\database_connection;

class CTGH_DAO {
    public function getByIDGH ($idgh) {
        $list = [];
        $query = "SELECT * FROM CTGH where IDGH = ?";
        $rs = database_connection::executeQuery($query, $idgh);
        while($row = $rs->fetch_assoc()) {
            $model = $this->createCTGHModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    public function addGH($model) {
        // $list = app(CTSP_BUS::class)->getCTSPByIDSP($model->);
        $query = "INSERT INTO CTGH (IDGH, IDSP, SOLUONG) VALUES (?,?)";
        $args = [$model->getIdGH(), $model->getIdSP(), $model->getSoLuong()];
        return database_connection::executeUpdate($query, ...$args);
    }
    public function deleteCTGH($idgh, $idsp) {
        $query = "DELETE FROM CTGH WHERE IDGH = ? AND IDSP = ?";
        $args = [$idgh, $idsp];
        return database_connection::executeUpdate($query, ...$args);
    }
    // public function checkSP($idgh, $idsp) {
    //     $listctgh = $this->getByIDGH($idgh);
    //     $index = 0;
    //     foreach($listctgh as $it) {
    //         $sp = app(CTSP_BUS::class)->getSPBySoSeri($it->getSoSeri());
    //         if($sp->getId() === $idsp) {
    //             $index += 1;
    //         }
    //     }
    //     return $index;
    // }
    
    // public function getListSPFromCTGH($idgh) {
    //     $listctgh = $this->getByIDGH($idgh);
    //     $result = [];
    
    //     foreach ($listctgh as $it) {
    //         $sp = app(CTSP_BUS::class)->getSPBySoSeri($it->getSoSeri());
    //         $idsp = $sp->getId();
    
    //         if (isset($result[$idsp])) {
    //             $result[$idsp] += 1;
    //         } else {
    //             $result[$idsp] = 1;
    //         }
    //     }
    
    //     return $result; // mảng có dạng [idsp => soluong, ...]
    // }
    public function createCTGHModel($row) {
        $idsp = app(SanPham_BUS::class)->getModelById($row['IDSP']);
        $idgh = app(GioHang_BUS::class)->getModelById($row['IDGH']);
        return new CTGH($idgh, $idsp, $row['SOLUONG']);
    }
    public function getCTGHByIDGHAndIDSP($idGH, $idsp) {
        $query = "SELECT * FROM CTGH WHERE IDGH = ? AND IDSP = ?";
        $args = [$idGH, $idsp];
        $result = database_connection::executeQuery($query, ...$args);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row) {
                return $this->createCTGHModel($row);
            }
        }
        return null;
    }
    public function updateCTGH($model) {
        $query = "UPDATE CTGH SET SOLUONG = ? WHERE IDGH = ? AND IDSP = ?";
        $args = [$model->getSoLuong(), $model->getIdGH()->getIdGH(), $model->getIdSP()->getId()];
        $result = database_connection::executeUpdate($query, ...$args);
        return is_int($result) ? $result : 0;  
    }
    public function searchCTGHByKeyword($idgh, $keyword) {
        $query = "SELECT ctgh.IDGH, ctgh.IDSP, ctgh.SOLUONG
                    FROM ctgh
                    JOIN sanpham ON ctgh.IDSP = sanpham.ID
                    WHERE ctgh.IDGH = ? 
                    AND (
                        sanpham.TENSANPHAM LIKE ?
                        OR sanpham.IDLSP IN (SELECT IDLSP FROM sanpham WHERE TENSANPHAM LIKE ?)
                        OR sanpham.IDHANG IN (SELECT IDHANG FROM sanpham WHERE TENSANPHAM LIKE ?)
                    );";
        $list = [];
        $args = [$idgh, $keyword, $keyword, $keyword];
        $rs = database_connection::executeQuery($query, ...$args);
        while($row = $rs->fetch_assoc()) {
            $model = $this->createCTGHModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    
}
?>