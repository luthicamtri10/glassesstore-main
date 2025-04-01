<?php
namespace App\Models;

class ChiTietBaoHanh {
    private int $idKhachHang;
    private int $idSanPham;
    private float $chiPhiBH;
    private \DateTime $thoiDiemBH;
    private string $soSeri;
    private int $trangThaiHD;

    public function __construct(int $idKhachHang, int $idSanPham, float $chiPhiBH, string $thoiDiemBH, string $soSeri, int $trangThaiHD) {
        $this->idKhachHang = $idKhachHang;
        $this->idSanPham = $idSanPham;
        $this->chiPhiBH = $chiPhiBH;
        $this->thoiDiemBH = new \DateTime($thoiDiemBH);
        $this->soSeri = $soSeri;
        $this->trangThaiHD = $trangThaiHD;

    }

    public function getIdKhachHang(): int {
        return $this->idKhachHang;
    }

    public function getIdSanPham(): int {
        return $this->idSanPham;
    }

    public function getChiPhiBH(): float {
        return $this->chiPhiBH;
    }

    public function getThoiDiemBH(): \DateTime {
        return $this->thoiDiemBH;
    }

    public function getSoSeri(): string {
        return $this->soSeri;
    }
    public function getTrangThaiHD(): int {
        return $this->trangThaiHD;
    }

    public function setIdKhachHang(int $idKhachHang): void {
        $this->idKhachHang = $idKhachHang;
    }

    public function setIdSanPham(int $idSanPham): void {
        $this->idSanPham = $idSanPham;
    }

    public function setChiPhiBH(float $chiPhiBH): void {
        $this->chiPhiBH = $chiPhiBH;
    }

    public function setThoiDiemBH(string $thoiDiemBH): void {
        $this->thoiDiemBH = new \DateTime($thoiDiemBH);
    }

    public function setSoSeri(string $soSeri): void {
        $this->soSeri = $soSeri;
    }
    public function setTrangThaiHD(int $trangThaiHD): void {
         $this->trangThaiHD = $trangThaiHD;
    }
}

?>