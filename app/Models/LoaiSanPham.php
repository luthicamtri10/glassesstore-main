<?php
namespace App\Models;

class LoaiSanPham {
    private int $id;
    private string $tenLSP;
    private string $moTa;
    private $trangThaiHD; 

    public function __construct(int $id, string $tenLSP, string $moTa, $trangThaiHD) {
        $this->id = $id;
        $this->tenLSP = $tenLSP;
        $this->moTa = $moTa;
        $this->trangThaiHD = $trangThaiHD;
    }

    public function getId(): int {
        return $this->id;
    }

    public function gettenLSP(): string {
        return $this->tenLSP;
    }

    public function getmoTa(): string {
        return $this->moTa;
    }

    public function gettrangThaiHD() {
        return $this->trangThaiHD;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function settenLSP(string $tenLSP): void {
        $this->tenLSP = $tenLSP;
    }

    public function setmoTa(string $moTa): void {
        $this->moTa = $moTa;
    }

    public function settrangThaiHD($trangThaiHD): void {
        $this->trangThaiHD = $trangThaiHD;
    }
}
?>
