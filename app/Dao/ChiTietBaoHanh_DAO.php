<?php

namespace App\Dao;

use App\Bus\NguoiDung_BUS;
use App\Bus\CTSP_BUS;
use App\Interface\DAOInterface;
use App\Models\ChiTietBaoHanh;
use App\Services\database_connection;
use InvalidArgumentException;
use RuntimeException;

class ChiTietBaoHanh_DAO implements DAOInterface
{
    private $ctspBUS;
    private $ndBUS;

    public function __construct(CTSP_BUS $ctspBUS, NguoiDung_BUS $ndBUS)
    {
        $this->ctspBUS = $ctspBUS;
        $this->ndBUS = $ndBUS;
    }

    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM chitietbaohanh");
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createModel($row);
        }
        return $list;
    }

    private function createModel(array $rs): ChiTietBaoHanh
    {
        $idKhachHang = $this->ndBUS->getModelById($rs['IDKHACHHANG']);
        $soSeri = $this->ctspBUS->getSPBySoSeri($rs['SOSERI']);

        if (!$idKhachHang || !$soSeri) {
            throw new RuntimeException("Dữ liệu không hợp lệ trong ChiTietBaoHanh_DAO::createModel");
        }

        return new ChiTietBaoHanh(
            $idKhachHang,
            $soSeri,
            $rs['CHIPHIBH'],
            $rs['THOIDIEMBAOHANH']
        );
    }

    public function getAll(): array
    {
        return $this->readDatabase();
    }

    public function getAllByIdKH($idkh): array
    {
        $list = [];
        $query = "SELECT * FROM chitietbaohanh WHERE IDKHACHHANG = ?";
        $result = database_connection::executeQuery($query, $idkh);

        while ($row = $result->fetch_assoc()) {
            $list[] = $this->createModel($row);
        }

        return $list;
    }

    public function getBySoseri($soseri): ?ChiTietBaoHanh
    {
        $query = "SELECT * FROM chitietbaohanh WHERE SOSERI = ?";
        $result = database_connection::executeQuery($query, $soseri);

        if ($result->num_rows > 0) {
            return $this->createModel($result->fetch_assoc());
        }
        return null;
    }

    public function getByIdKHAndSoSeri($idkh, $soseri): ?ChiTietBaoHanh
    {
        $query = "SELECT * FROM chitietbaohanh WHERE IDKHACHHANG = ? AND SOSERI = ?";
        $result = database_connection::executeQuery($query, $idkh, $soseri);

        if ($result->num_rows > 0) {
            return $this->createModel($result->fetch_assoc());
        }
        return null;
    }

    private function isValidForWarranty(int $idKhachHang, string $soSeri): bool
    {
        $query = "
            SELECT cthd.TRANGTHAIBH
            FROM hoadon hd
            INNER JOIN chitiethoadon cthd ON hd.ID = cthd.IDHD
            WHERE cthd.SOSERI = ? AND hd.IDKHACHHANG = ? AND hd.TRANGTHAI = 'PAID'
        ";

        $rs = database_connection::executeQuery($query, $soSeri, $idKhachHang);

        if ($rs->num_rows === 0) {
            return false;
        }

        $row = $rs->fetch_assoc();
        return ((int)$row['TRANGTHAIBH'] === 1);
    }

    public function insert($e): int
    {
        $query = "
            INSERT INTO chitietbaohanh (IDKHACHHANG, SOSERI, CHIPHIBH, THOIDIEMBAOHANH)
            VALUES (?, ?, ?, ?)
        ";
        $args = [
            $e->getKhachHang()->getId(),
            $e->getSoSeri()->getSoSeri(),
            $e->getChiPhiBH(),
            $e->getThoiDiemBH()
        ];
        $rs = database_connection::executeUpdate($query, ...$args);
        return is_int($rs) ? $rs : 0;
    }

    public function update($e): int
    {
        $query = "
            UPDATE chitietbaohanh
            SET CHIPHIBH = ?, THOIDIEMBAOHANH = ?, IDKHACHHANG = ?
            WHERE SOSERI = ?
        ";
        $args = [
            $e->getChiPhiBH(),
            $e->getThoiDiemBH(),
            $e->getKhachHang()->getId(),
            $e->getSoSeri()->getSoSeri()
        ];
        $rs = database_connection::executeUpdate($query, ...$args);
        return is_int($rs) ? $rs : 0;
    }

    public function delete($soSeri): int
    {
        $query = "DELETE FROM chitietbaohanh WHERE SOSERI = ?";
        $rs = database_connection::executeUpdate($query, $soSeri);
        return is_int($rs) ? $rs : 0;
    }

    public function search(string $condition, array $columnNames = []): array
    {
        if (empty($condition)) {
            throw new InvalidArgumentException("Điều kiện tìm kiếm không được để trống");
        }

        $columns = empty($columnNames)
            ? ['IDKHACHHANG', 'CHIPHIBH', 'THOIDIEMBAOHANH', 'SOSERI']
            : $columnNames;

        $likeConditions = array_map(fn($col) => "$col LIKE ?", $columns);
        $query = "SELECT * FROM chitietbaohanh WHERE " . implode(" OR ", $likeConditions);
        $args = array_fill(0, count($columns), "%" . $condition . "%");

        $rs = database_connection::executeQuery($query, ...$args);

        $list = [];
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createModel($row);
        }
        return $list;
    }
}
