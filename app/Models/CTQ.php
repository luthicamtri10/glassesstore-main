<?php
namespace App\Models;
class CTQ {
    private $idQuyen, $idChucNang, $thaoTac, $trangThaiHD;
    public function __construct($idQuyen, $idChucNang, $thaoTac, $trangThaiHD)
    {
        $this->idQuyen = $idQuyen;
        $this->idChucNang = $idChucNang;
        $this->thaoTac = $thaoTac;
        $this->trangThaiHD = $trangThaiHD;
    }

    public function getIdQuyen(){
        return $this->idQuyen;
    }

    public function getIdChucNang(){
        return $this->idChucNang;
    }

    public function getThaoTac(){
        return $this->thaoTac;
    }

    public function getTrangThaiHD(){
        return $this->trangThaiHD;
    }

    public function setIdQuyen($idQuyen){
        $this->idQuyen = $idQuyen;
    }

    public function setIdChucNang($idChucNang){
        $this->idChucNang = $idChucNang;
    }

    public function setThaoTac($thaoTac){
        $this->thaoTac = $thaoTac;
    }

    public function setTrangThaiHD($trangthaiHD){
        $this->trangThaiHD = $trangthaiHD;
    }
}
?>