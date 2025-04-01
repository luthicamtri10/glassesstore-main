<?php

namespace App\Dao;
use App\Bus\NguoiDung_BUS;
use App\Bus\NCC_BUS;
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
        $rs = database_connection::executeQuery("SELECT * FROM phieunhap");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createPhieuNhapModel($row);
            $list[] = $model;
        }
        return $list;
    }
    public function createPhieuNhapModel($rs): PhieuNhap
    {
        $trangThaiHD = $rs['trangThaiHD'];
        switch ($trangThaiHD) {
            case 'PAID':
                $trangThaiHD = ReceiptStatus::PAID;
                break;
            case 'UNPAID':
                $trangThaiHD = ReceiptStatus::UNPAID;
                break;
            default:
                error("Can not create PhieuNhap model");
                break;
        }
        $id = $rs['id'];
        $idNCC = app(NCC_BUS::class)->getModelById($rs['idNCC']);
        $tongTien = $rs['tongTien'];
        $ngayTao = $rs['ngayTao'];
        $idNhanVien = app(NguoiDung_BUS::class)->getModelById($rs['idNhanVien']);
        return new PhieuNhap($id,$idNCC,$tongTien,$ngayTao,$idNhanVien,$trangThaiHD);
    }
    public function getAll(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM phieunhap");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createPhieuNhapModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    public function getById($id): ?PhieuNhap
    {
        $query = "SELECT * FROM phieunhap WHERE ID = ?";
        $result = database_connection::executeQuery($query, $id);
        if ($result->num_rows > 0) {
            return $this->createPhieuNhapModel($result->fetch_assoc());
        }
        return null;
    }
    private function supplierExists(int $idNCC): bool
    {
        $query = "SELECT COUNT(*) as count FROM ncc WHERE ID = ?";
        $rs = database_connection::executeQuery($query, $idNCC);
        $row = $rs->fetch_assoc();
        return $row['count'] > 0;
    }

    /**
     * Kiểm tra sự tồn tại của idNhanVien trong bảng nguoidung
     */
    private function employeeExists(int $idNhanVien): bool
    {
        $query = "SELECT COUNT(*) as count FROM nguoidung WHERE ID = ?";
        $rs = database_connection::executeQuery($query, $idNhanVien);
        $row = $rs->fetch_assoc();
        return $row['count'] > 0;
    }
    public function insert($e): int
    {
        if (!$e instanceof PhieuNhap) {
            throw new InvalidArgumentException("Tham số phải là instance của PhieuNhap");
        }
        // Kiểm tra khóa ngoại
        if (!$this->supplierExists($e->getIdNCC())) {
            throw new \Exception("ID nhà cung cấp {$e->getIdNCC()} không tồn tại trong bảng nhacungcap.");
        }
        if (!$this->employeeExists($e->getIdNhanVien())) {
            throw new \Exception("ID nhân viên {$e->getIdNhanVien()} không tồn tại trong bảng nguoidung.");
        }
        $query = "INSERT INTO phieunhap (ID, IDNCC, TONGTIEN, NGAYTAO, IDNHANVIEN, TRANGTHAIHD) VALUES (?,?,?,?,?,?)";
        $args = [$e->getId(), $e->getIdNCC(), $e->getTongTien(), $e->getNgayTao(), $e->getIdNhanVien(), $e->getTrangThaiHD()];
        $rs = database_connection::executeQuery($query, ...$args);
        return is_int($rs) ? $rs : 0;
    }
    public function update($e): int
    {
        // Kiểm tra khóa ngoại
        if (!$this->supplierExists($e->getIdNCC())) {
            throw new \Exception("ID nhà cung cấp {$e->getIdNCC()} không tồn tại trong bảng nhacungcap.");
        }
        if (!$this->employeeExists($e->getIdNhanVien())) {
            throw new \Exception("ID nhân viên {$e->getIdNhanVien()} không tồn tại trong bảng nguoidung.");
        }
        $query = "UPDATE phieunhap SET IDNCC = ?, TONGTIEN = ?, NGAYTAO = ?, IDNHANVIEN = ?, TRANGTHAIHD = ? WHERE ID = ?";
        $args = [$e->getIdNCC(), $e->getTongTien(), $e->getNgayTao(), $e->getIdNhanVien(), $e->getTrangThaiHD(), $e->getId()];
        $rs = database_connection::executeUpdate($query, ...$args);
        return is_int($rs) ? $rs : 0;
    }
    public function delete(int $id): int
    {
        $query = "DELETE FROM phieunhap WHERE ID = ?";
        $rs = database_connection::executeUpdate($query, $id);
        return is_int($rs) ? $rs : 0;
    }
    public function exists(int $id): bool
    {
        $query = "SELECT COUNT(*) as count FROM phieunhap WHERE ID = ?";
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
            ? ["ID", "IDNCC", "TONGTIEN", "IDNHANVIEN", "NGAYTAO", "TRANGTHAIHD"]
            : $columnNames;

        // Xây dựng câu lệnh SQL với các cột được chỉ định
        $query = "SELECT * FROM phieunhap WHERE " . implode(" LIKE ? OR ", $columns) . " LIKE ?";

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
