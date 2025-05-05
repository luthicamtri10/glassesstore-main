<?php
namespace App\Models;
class CTGH {
    private GioHang $gioHang;
    private SanPham $sanPham;
    private $soluong;
    public function __construct($gioHang, $sanPham, $soluong)
    {
        $this->gioHang = $gioHang;
        $this->sanPham = $sanPham;
        $this->soluong = $soluong;
    }
    public function getGH() : GioHang {
        return $this->gioHang;
    }
    public function getSP() : SanPham {
        return $this->sanPham;
    }
    public function getSoLuong() {
        return $this->soluong;
    }
    public function setGH(GioHang $gioHang) {
        $this->gioHang = $gioHang;
    }
    public function setSP(SanPham $sanPham) {
        $this->sanPham = $sanPham;
    }
    public function setSoLuong($soluong) {
        $this->soluong = $soluong;
    }
}
?>