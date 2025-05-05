<?php

namespace App\Dao;

use App\Bus\GioHang_BUS;
use App\Bus\SanPham_BUS;
use App\Models\CTGH;
use App\Services\database_connection;

class CTGH_DAO {
    private $ghBUS;
    private $spBUS;
    public function __construct(GioHang_BUS $ghBUS, SanPham_BUS $spBUS) {
        $this->ghBUS = $ghBUS;
        $this->spBUS = $spBUS;
   
    }
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
    public function addCTGH($model) {
        // $list = app(CTSP_BUS::class)->getCTSPByIDSP($model->);
        $query = "INSERT INTO `ctgh`(`IDGH`, `IDSP`, `SOLUONG`) VALUES (?,?,?)";
        $args = [$model->getIdGH()->getIdGH(), $model->getIdSP()->getId(), $model->getSoLuong()];
        return database_connection::executeUpdate($query, ...$args);
    }
    public function deleteCTGH($idgh, $idsp) {
        $query = "DELETE FROM CTGH WHERE IDGH = ? AND IDSP = ?";
        $args = [$idgh, $idsp];
        return database_connection::executeUpdate($query, ...$args);
    }
    public function createCTGHModel($row) {
        $idsp = $this->spBUS->getModelById($row['IDSP']);
        $idgh = $this->ghBUS->getModelById($row['IDGH']);
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
    // public function searchCTGHByKeyword($idgh, $keyword) {
    //     $query = "SELECT ctgh.IDGH, ctgh.IDSP, ctgh.SOLUONG
    //                 FROM ctgh
    //                 JOIN sanpham ON ctgh.IDSP = sanpham.ID
    //                 WHERE ctgh.IDGH = ? 
    //                 AND (
    //                     sanpham.TENSANPHAM LIKE ?
    //                     OR sanpham.IDLSP IN (SELECT IDLSP FROM sanpham WHERE TENSANPHAM LIKE ?)
    //                     OR sanpham.IDHANG IN (SELECT IDHANG FROM sanpham WHERE TENSANPHAM LIKE ?)
    //                 );";
    //     $list = [];
    //     $args = [$idgh, $keyword, $keyword, $keyword];
    //     $rs = database_connection::executeQuery($query, ...$args);
    //     while($row = $rs->fetch_assoc()) {
    //         $model = $this->createCTGHModel($row);
    //         array_push($list, $model);
    //     }
    //     return $list;
    // }
    
}
?>