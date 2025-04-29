<?php
namespace App\Models;


class PhieuNhap {
    private $id;
    private NCC $idNCC;
    private  $tongTien;
    private $ngayTao;
    private NguoiDung $idNhanVien;
    private  $trangThaiPN;

    public function __construct(int $id, NCC $idNCC,  $tongTien, string $ngayTao, NguoiDung $idNhanVien, $trangThaiPN) {
        $this->id = $id;
        $this->idNCC = $idNCC;
        $this->tongTien = $tongTien;
        $this->ngayTao = $ngayTao;
        $this->idNhanVien = $idNhanVien;
        $this->trangThaiPN = $trangThaiPN;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getIdNCC(): NCC {
        return $this->idNCC;
    }

    public function getTongTien() {
        return $this->tongTien;
    }

    public function getNgayTao(){
        return $this->ngayTao;
    }

    public function getIdNhanVien(): NguoiDung {
        return $this->idNhanVien;
    }

    public function getTrangThaiPN() {
        return $this->trangThaiPN;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setIdNCC(NCC $idNCC): void {
        $this->idNCC = $idNCC;
    }

    public function setTongTien($tongTien): void {
        $this->tongTien = $tongTien;
    }

    public function setNgayTao($ngayTao): void {
        $this->ngayTao = $ngayTao;
    }

    public function setIdNhanVien(NguoiDung $idNhanVien): void {
        $this->idNhanVien = $idNhanVien;
    }

    public function setTrangThaiPN( $trangThaiPN): void {
        $this->trangThaiPN = $trangThaiPN;
    }
}

?>

