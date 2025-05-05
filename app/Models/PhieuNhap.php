<?php
namespace App\Models;

use App\Enum\ReceiptStatus;

class PhieuNhap {
    private int $id;
    private NguoiDung $ndModel;
    private NCC $nccModel;
    private float $tongTien;
    private  String $ngayTao;
    private int $trangThaiHD;

    public function __construct(int $id, NCC $nccModel, float $tongTien, String $ngayTao, NguoiDung $ndModel, int $trangThaiHD) {
        $this->id = $id;
        $this->nccModel = $nccModel;
        $this->tongTien = $tongTien;
        $this->ngayTao = $ngayTao;
        $this->ndModel = $ndModel;
        $this->trangThaiHD = $trangThaiHD;
    }
   

    public function getId(): int {
        return $this->id;
    }

    public function getNCC(): NCC {
        return $this->nccModel;
    }

    public function getTongTien(): float {
        return $this->tongTien;
    }

    public function getNgayTao(): String {
        return $this->ngayTao;
    }

    public function getNhanVien(): NguoiDung {
        return $this->ndModel;
    }

    public function getTrangThaiHD(): int {
        return $this->trangThaiHD;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setNCC(NCC $nccModel): void {
        $this->nccModel = $nccModel;
    }

    public function setTongTien(float $tongTien): void {
        $this->tongTien = $tongTien;
    }

    public function setNgayTao(string $ngayTao): void {
        $this->ngayTao = ($ngayTao);
    }

    public function setIdNhanVien(NguoiDung $ndModel): void {
        $this->ndModel = $ndModel;
    }

    public function setTrangThaiHD(int $trangThaiHD): void {
        $this->trangThaiHD = $trangThaiHD;
    }
}

?>