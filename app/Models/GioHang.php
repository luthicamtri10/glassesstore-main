<?php
namespace App\Models;

class GioHang {
    private string $email;
    private int $idSanPham;
    private string $soSeri;

    public function __construct(string $email, int $idSanPham, string $soSeri) {
        $this->email = $email;
        $this->idSanPham = $idSanPham;
        $this->soSeri = $soSeri;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getIdSanPham(): int {
        return $this->idSanPham;
    }

    public function getSoSeri(): string {
        return $this->soSeri;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setIdSanPham(int $idSanPham): void {
        $this->idSanPham = $idSanPham;
    }

    public function setSoSeri(string $soSeri): void {
        $this->soSeri = $soSeri;
    }
}

?>
