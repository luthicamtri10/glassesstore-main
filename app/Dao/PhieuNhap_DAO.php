<?php

namespace App\Dao;

use App\Enum\ReceiptStatus;
use App\Interface\DAOInterface;
use App\Models\PhieuNhap;
use App\Services\database_connection;
use Illuminate\Support\Arr;
use InvalidArgumentException;

use function Laravel\Prompts\error;

class PhieuNhap_DAO implements DAOInterface
{
    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM PHIEUNHAP");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createPhieuNhapModel($row);
            $list[] = $model;
        }
        return $list;
    }
    public function createPhieuNhapModel($rs): PhieuNhap
    {
        $trangThai = $rs['trangThai'];
        switch ($trangThai) {
            case 'PAID':
                $trangThai = ReceiptStatus::PAID;
                break;
            case 'UNPAID':
                $trangThai = ReceiptStatus::UNPAID;
                break;
            default:
                error("Can not create PhieuNhap model");
                break;
        }
        return new PhieuNhap(
            $rs['id'],
            $rs['idNCC'],
            $rs['tongTien'],
            $rs['ngayTao'],
            $rs['idNhanVien'],
            $trangThai


        );
    }
    public function getAll(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM PHIEUNHAP");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createPhieuNhapModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    public function getById($id): ?PhieuNhap
    {
        $query = "SELECT * FROM PHIEUNHAP WHERE id = ?";
        $result = database_connection::executeQuery($query, $id);
        if ($result->num_rows > 0) {
            return $this->createPhieuNhapModel($result->fetch_assoc());
        }
        return null;
    }
    public function insert($e): int
    {
        $query = "INSERT INTO PHIEUNHAP (id, idNCC, tongTien, ngayTao, idNhanVien, trangThai) VALUES (?,?,?,?,?,?)";
        $args = [$e->getId(), $e->getIdNCC(), $e->getTongTien(), $e->getNgayTao(), $e->getIdNhanVien(), $e->getTrangThai()];
        $rs = database_connection::executeQuery($query, ...$args);
        return is_int($rs) ? $rs : 0;
    }
    public function update($e): int
    {
        $query = "UPDATE PHIEUNHAP SET idNCC = ?, tongTien = ?, ngayTao = ?, idNhanVien = ?, trangThai = ? WHERE id = ?";
        $args = [$e->getIdNCC(), $e->getTongTien(), $e->getNgayTao(), $e->getIdNhanVien(), $e->getTrangThai(), $e->getId()];
        $rs = database_connection::executeUpdate($query, ...$args);
        return is_int($rs) ? $rs : 0;
    }
    public function delete(int $id): int
    {
        $query = "DELETE FROM PHIEUNHAP WHERE id = ?";
        $rs = database_connection::executeUpdate($query, $id);
        return is_int($rs) ? $rs : 0;
    }
    public function exists(int $id): bool
    {
        $query = "SELECT COUNT(*) as count FROM PHIEUNHAP WHERE id = ?";
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
        $query = "SELECT * FROM PHIEUNHAP WHERE " . implode(" LIKE ? OR ", $columns) . " LIKE ?";

        // Mảng chứa các tham số tìm kiếm
        $args = array_fill(0, count($columns), "%" . $condition . "%");

        $rs = database_connection::executeQuery($query, ...$args);
        $list = [];

        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createPhieuNhapModel($row);
        }

        return $list;
    }
}
