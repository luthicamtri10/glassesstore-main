<?php
namespace App\Models;

use App\Enum\ReceiptStatus;

class PhieuNhap {
    private int $id;
    private int $idNCC;
    private float $tongTien;
    private \DateTime $ngayTao;
    private int $idNhanVien;
    private ReceiptStatus $trangThaiPN;
    private ?NCC $ncc;
    private array $chiTietPhieuNhaps;

    public function __construct(int $id, int $idNCC, float $tongTien, string $ngayTao, int $idNhanVien, ReceiptStatus $trangThaiPN) {
        $this->id = $id;
        $this->idNCC = $idNCC;
        $this->tongTien = $tongTien;
        $this->ngayTao = new \DateTime($ngayTao);
        $this->idNhanVien = $idNhanVien;
        $this->trangThaiPN = $trangThaiPN;
        $this->ncc = null;
        $this->chiTietPhieuNhaps = [];
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

    public function getTrangThaiPN(): ReceiptStatus {
        return $this->trangThaiPN;
    }

    public function getNCC(): ?NCC
    {
        return $this->ncc;
    }

    public function getChiTietPhieuNhaps(): array {
        return $this->chiTietPhieuNhaps;
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

    public function setTrangThaiPN(ReceiptStatus $trangThaiPN): void {
        $this->trangThaiPN = $trangThaiPN;
    }

    public function setNCC(?NCC $ncc): void {
        $this->ncc = $ncc;
    }

    public function setChiTietPhieuNhaps(array $chiTiet): void {
        $this->chiTietPhieuNhaps = $chiTiet;
    }

    // Phương thức tìm kiếm theo ID
    public function searchById(int $id): ?self {
        if ($this->id == $id) {
            return $this;
        }
        return null;
    }

    // Phương thức tìm kiếm theo nhà cung cấp
    public function searchByNCC(int $idNCC): ?self {
        if ($this->idNCC == $idNCC) {
            return $this;
        }
        return null;
    }

    // Phương thức tìm kiếm theo ngày tạo
    public function searchByDate(string $date): ?self {
        if ($this->ngayTao->format('Y-m-d') == $date) {
            return $this;
        }
        return null;
    }

    // Phương thức tìm kiếm theo trạng thái
    public function searchByStatus(ReceiptStatus $status): ?self {
        if ($this->trangThaiPN == $status) {
            return $this;
        }
        return null;
    }

    // Phương thức tìm kiếm theo tổng tiền
    public function searchByTotal(float $min, float $max): ?self {
        if ($this->tongTien >= $min && $this->tongTien <= $max) {
            return $this;
        }
        return null;
    }
}

?>

