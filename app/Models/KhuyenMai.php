<?php
namespace App\Models;

class KhuyenMai {
    private int $id;
    private int $idSanPham;
    private $dieuKien; 
    private float $phanTramGiamGia;
    private \DateTime $ngayBatDau;  
    private \DateTime $ngayKetThuc; 
    private string $moTa;
    private int $soLuongTon;

    public function __construct(int $id, int $idSanPham, $dieuKien, float $phanTramGiamGia, \DateTime $ngayBatDau, \DateTime $ngayKetThuc, string $moTa, int $soLuongTon) {
        $this->id = $id;
        $this->idSanPham = $idSanPham;
        $this->dieuKien = $dieuKien;
        $this->phanTramGiamGia = $phanTramGiamGia;
        $this->ngayBatDau = $ngayBatDau;
        $this->ngayKetThuc = $ngayKetThuc;
        $this->moTa = $moTa;
        $this->soLuongTon = $soLuongTon;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getIdSanPham(): int {
        return $this->idSanPham;
    }

    public function getdieuKien() {
        return $this->dieuKien;  
    }

    public function getphanTramGiamGia(): float {
        return $this->phanTramGiamGia;
    }

    public function getngayBatDau(): \DateTime {
        return $this->ngayBatDau;
    }

    public function getngayKetThuc(): \DateTime {
        return $this->ngayKetThuc;
    }

    public function getmoTa(): string {
        return $this->moTa;
    }

    public function getsoLuongTon(): int {
        return $this->soLuongTon;
    }


    
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setIdSanPham(int $idSanPham): void {
        $this->idSanPham = $idSanPham;
    }

    public function setdieuKien($dieuKien): void {
        $this->dieuKien = $dieuKien;
    }

    public function setphanTramGiamGia(float $phanTramGiamGia): void {
        $this->phanTramGiamGia = $phanTramGiamGia;
    }

    public function setngayBatDau(\DateTime $ngayBatDau): void {
        $this->ngayBatDau = $ngayBatDau;
    }

    public function setngayKetThuc(\DateTime $ngayKetThuc): void {
        $this->ngayKetThuc = $ngayKetThuc;
    }

    public function setmoTa(string $moTa): void {
        $this->moTa = $moTa;
    }

    public function setsoLuongTon(int $soLuongTon): void {
        $this->soLuongTon = $soLuongTon;
    }
}
?>
