<?php

namespace App\Dao;

use App\Interface\DAOInterface;
use App\Models\ChiTietBaoHanh;
use App\Services\database_connection;
use Illuminate\Support\Arr;
use InvalidArgumentException;

use function Laravel\Prompts\error;

class ChiTietBaoHanh_DAO implements DAOInterface
{
    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM CHITIETBAOHANH");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createCTBHModel($row);
            $list[] = $model;
        }
        return $list;
    }
    public function createCTBHModel($rs): ChiTietBaoHanh
    {
        
        return new ChiTietBaoHanh(
            $rs['idKhachHang'],
            $rs['idSanPham'],
            $rs['chiPhiBaoHanh'],
            $rs['thoiDiemBaohanh'],
            $rs['soSeri']
        );
    }
    public function getAll(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM CHITIETBAOHANH");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createCTBHModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    public function getById($id)
    {
        $query = "SELECT * FROM CHITIETBAOHANH WHERE id = ?";
        $result = database_connection::executeQuery($query, $id);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row) {
                return $this->createCTBHModel($row);
            }
        }
        return;
    }
    public function insert($e): int
    {
        $query = "INSERT INTO PhieuNhap (id, idNCC, tongTien, ngayTao, idNhanVien,trangThai) VALUES (?,?,?,?,?,?)";
        $args = [$e->getId(), $e->getIdNCC(), $e->getTongTien(), $e->getIdNhanVien(), $e->getNgayTao(), $e->gettrangThai()];
        $rs = database_connection::executeQuery($query, ...$args);
        return is_int($rs) ? $rs : 0;
    }
    public function update($e): int
    {
        $query = "UPDATE PhieuNhap SET idNCC = ?, tongTien = ?, ngayTao = ?, idNhanVien = ?, trangThai = ? WHERE id = ?";
        $args = [$e->getIdNCC(), $e->getTongTien(), $e->getNgayTao(), $e->getIdNhanVien(), $e->getTrangThai(), $e->getId()];
        $rs = database_connection::executeUpdate($query, ...$args);
        return is_int($rs) ? $rs : 0;
    }
    public function delete(int $id): int
    {
        $query = "DELETE FROM PhieuNhap WHERE id = ?";
        $rs = database_connection::executeUpdate($query, $id);
        return is_int($rs) ? $rs : 0;
    }
    public function exists(int $id): bool
    {
        $query = "SELECT COUNT(*) as count FROM PhieuNhap WHERE id = ?";
        $rs = database_connection::executeQuery($query, $id);
        $row = $rs->fetch_assoc();
        return $row['count'] > 0;
    }

    public function search(string $condition, array $columnNames = []): array
    {
        if (empty($condition)) {
            throw new InvalidArgumentException("Search condition cannot be empty or null");
        }

        // Danh sách cột mặc định nếu không truyền vào
        $columns = empty($columnNames)
            ? ["id", "idNCC", "tongTien", "idNhanVien", "ngayTao", "trangThai"]
            : $columnNames;

        // Xây dựng câu lệnh SQL với các cột được chỉ định
        $query = "SELECT * FROM PhieuNhap WHERE " . implode(" LIKE ? OR ", $columns) . " LIKE ?";

        // Mảng chứa các tham số tìm kiếm
        $args = array_fill(0, count($columns), "%" . $condition . "%");

        $rs = database_connection::executeQuery($query, ...$args);
        $list = [];

        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createCTBHModel($row);
        }

        return $list;
    }
}
