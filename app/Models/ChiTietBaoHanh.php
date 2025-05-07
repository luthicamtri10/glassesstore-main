<?php
namespace App\Models;

use Illuminate\Support\Facades\Date;

class ChiTietBaoHanh {
    private int $idkh;
    private float $chiPhiBH;
    private Date $thoiDiemBH;
    private String $soSeri;

    public function __construct(int $idkh, String $soSeri, float $chiPhiBH, String $thoiDiemBH) {
        $this->idkh = $idkh;
        $this->chiPhiBH = $chiPhiBH;
        $this->thoiDiemBH = new Date($thoiDiemBH);
        $this->soSeri = $soSeri;

    }

    public function getidKH(): int {
        return $this->idkh;
    }

  
    public function getChiPhiBH(): float {
        return $this->chiPhiBH;
    }

    public function getThoiDiemBH(): Date {
        return $this->thoiDiemBH;
    }

    public function getSoSeri(): String {
        return $this->soSeri;
    }
  

    public function setKhachHang(int $khachHang): void {
        $this->idkh = $khachHang;
    }

  

    public function setChiPhiBH(float $chiPhiBH): void {
        $this->chiPhiBH = $chiPhiBH;
    }

    public function setThoiDiemBH(string $thoiDiemBH): void {
        $this->thoiDiemBH = new Date($thoiDiemBH);
    }

    public function setSoSeri(String $soSeri): void {
        $this->soSeri = $soSeri;
    }
  
}

?>