<?php
namespace App\Models;

class Hang {
    private int $id;
    private string $tenHang;
    private string $moTa;
    private $trangThaiHD; 

    public function __construct(int $id, string $tenHang, string $moTa, $trangThaiHD) {
        $this->id = $id;
        $this->tenHang = $tenHang;
        $this->moTa = $moTa;
        $this->trangThaiHD = $trangThaiHD;
    }

    public function getId(): int {
        return $this->id;
    }

    public function gettenHang(): string {
        return $this->tenHang;
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

    public function settenHang(string $tenHang): void {
        $this->tenHang = $tenHang;
    }

    public function setmoTa(string $moTa): void {
        $this->moTa = $moTa;
    }

    public function settrangThaiHD($trangThaiHD): void {
        $this->trangThaiHD = $trangThaiHD;
    }
}
?>
