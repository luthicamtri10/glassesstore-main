<?php
namespace App\Models;

use App\Enum\ReceiptStatus;

class PhieuNhap {
    private int $id;
    private int $idNCC;
    private float $tongTien;
    private \DateTime $ngayTao;
    private int $idNhanVien;
    private ReceiptStatus $trangThaiHD;

    public function __construct(int $id, int $idNCC, float $tongTien, string $ngayTao, int $idNhanVien, ReceiptStatus $trangThaiHD) {
        $this->id = $id;
        $this->idNCC = $idNCC;
        $this->tongTien = $tongTien;
        $this->ngayTao = new \DateTime($ngayTao);
        $this->idNhanVien = $idNhanVien;
        $this->trangThaiHD = $trangThaiHD;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getIdNCC(): int {
        return $this->idNCC;
    }

    public function getTongTien(): float {
        return $this->tongTien;
    }

    public function getNgayTao(): \DateTime {
        return $this->ngayTao;
    }

    public function getIdNhanVien(): int {
        return $this->idNhanVien;
    }

    public function getTrangThaiHD(): ReceiptStatus {
        return $this->trangThaiHD;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setIdNCC(int $idNCC): void {
        $this->idNCC = $idNCC;
    }

    public function setTongTien(float $tongTien): void {
        $this->tongTien = $tongTien;
    }

    public function setNgayTao(string $ngayTao): void {
        $this->ngayTao = new \DateTime($ngayTao);
    }

    public function setIdNhanVien(int $idNhanVien): void {
        $this->idNhanVien = $idNhanVien;
    }

    public function setTrangThaiHD(ReceiptStatus $trangThaiHD): void {
        $this->trangThaiHD = $trangThaiHD;
    }
}

?>