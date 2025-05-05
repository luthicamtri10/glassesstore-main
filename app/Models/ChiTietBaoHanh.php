<?php
namespace App\Models;

use Illuminate\Support\Facades\Date;

class ChiTietBaoHanh {
    private NguoiDung $khachHang;
    private float $chiPhiBH;
    private Date $thoiDiemBH;
    private CTSP $soSeri;

    public function __construct(NguoiDung $khachHang, CTSP $soSeri, float $chiPhiBH, String $thoiDiemBH) {
        $this->khachHang = $khachHang;
        $this->chiPhiBH = $chiPhiBH;
        $this->thoiDiemBH = new Date($thoiDiemBH);
        $this->soSeri = $soSeri;

    }

    public function getKhachHang(): NguoiDung {
        return $this->khachHang;
    }

  
    public function getChiPhiBH(): float {
        return $this->chiPhiBH;
    }

    public function getThoiDiemBH(): Date {
        return $this->thoiDiemBH;
    }

    public function getSoSeri(): CTSP {
        return $this->soSeri;
    }
  

    public function setKhachHang(NguoiDung $khachHang): void {
        $this->khachHang = $khachHang;
    }

  

    public function setChiPhiBH(float $chiPhiBH): void {
        $this->chiPhiBH = $chiPhiBH;
    }

    public function setThoiDiemBH(string $thoiDiemBH): void {
        $this->thoiDiemBH = new Date($thoiDiemBH);
    }

    public function setSoSeri(CTSP $soSeri): void {
        $this->soSeri = $soSeri;
    }
  
}

?>
