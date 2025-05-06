<?php
namespace App\Models;
class CTGH {
    private int $idGH;
    private int $idsp;
    private int $soluong;
    public function __construct(int $idGH,int $idsp,int $soluong)
    {
        $this->idGH = $idGH;
        $this->idsp = $idsp;
        $this->soluong = $soluong;
    }
    public function getIdGH() : int {
        return $this->idGH;
    }
    public function getIdSP() : int {
        return $this->idsp;
    }
    public function getSoLuong() {
        return $this->soluong;
    }
    public function setIdGH(int $idgh) {
        $this->idGH = $idgh;
    }
    public function setIdSP(int $idsp) {
        $this->idsp = $idsp;
    }
    public function setSoLuong($soluong) {
        $this->soluong = $soluong;
    }
}
?>